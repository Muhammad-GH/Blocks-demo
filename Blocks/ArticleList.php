<?php

namespace App\Blocks;

use Genero\Sage\CacheTags\Concerns\BlockCacheTags;
use Genero\Sage\CacheTags\Tags\CoreTags;
use WP_Post;
use WP_Query;

class ArticleList extends Block
{
    use BlockCacheTags;

    public $name = 'Article List';
    public $description = 'Show a list of articles...';
    public $category = 'widgets';
    public $icon = 'format-aside';
    public $keywords = ['news', 'uutiset', 'artikkelit'];
    public $mode = 'auto';
    public $supports = [
        'align' => ['full', 'wide'],
        'mode' => false,
    ];

    public $styles = [
        [
            'name' => 'default',
            'label' => 'List',
            'isDefault' => true,
        ],
        [
            'name' => 'featured',
            'label' => 'Featured',
        ],
    ];

    public function with()
    {
        return [
            'featured_post' => $this->featuredPost(),
            'query' => $this->query(),
            'use_pagination' => get_field('use_pagination'),
        ];
    }

    public function featuredPost(): ?WP_Post
    {
        if ($this->getBlockStyle() !== 'featured') {
            return null;
        }

        if (!$this->query()->have_posts()) {
            return null;
        }

        $this->query()->the_post();
        return $this->query()->post;
    }



    public function query(): WP_Query
    {
        $query = $this->buildQuery();
        $cid = substr(md5(json_encode($query)), 0, 8);

        static $cache = [];
        if (!isset($cache[$cid])) {
            $cache[$cid] = new WP_Query($query);
        }

        return $cache[$cid];
    }

    public function buildQuery(): array
    {
        $query = [
            'posts_per_page' => (int) get_field('posts_per_page') ?: 4,
            'order_by' => get_field('order_by') ?: ['date'],
            'order' => get_field('order') ?: 'DESC',
            'post_type' => 'post',
            'use_pagination' => get_field('use_pagination') ?? false,
            'ignore_sticky_posts' => get_field('ignore_sticky_posts') ?? false,
            'post_status' => 'publish',
            'paged' => get_field('use_pagination') ? (get_query_var('paged') ?: 1) : null,
        ];

        if ($postIn = get_field('post__in')) {
            $query['post__in'] = $postIn;
            $query['orderby'] = 'post__in';
            $query['order'] = 'ASC';
        }

        if ($categories = get_field('category')) {
            $query['tax_query'][] = [
                'taxonomy' => 'category',
                'terms' => $categories,
            ];
        }

        return $query;
    }

    public function render($block, $content = '', $preview = false, $post = 0)
    {
        if (!$this->query()->have_posts()) {
            if (is_bool($preview) && $preview) {
                return '<div class="acf-block-placeholder text-center">' . __('No results found...') . '</div>';
            }
            return '';
        }

        return parent::render(...func_get_args());
    }

    public function cacheTags(): array
    {
        if (empty($this->buildQuery()['post__in'])) {
            return [
                ...CoreTags::archive('post'),
            ];
        }
        return [];
    }
}
