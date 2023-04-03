<?php

namespace App\Blocks;

class TrainingList extends ArticleList
{
    public $name = 'Training List';
    public $description = 'Show a list of training events...';
    public $category = 'widgets';
    public $icon = 'format-aside';
    public $keywords = ['event', 'koulutus'];

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
        [
            'name' => 'full',
            'label' => 'Full view',
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

    public function buildQuery(): array
    {
        $query = [
            'orderby' => 'meta_value',
            'meta_key' => 'start_date',
            'posts_per_page' => (int) get_field('posts_per_page') ?: 4,
            'post_type' => 'training',
            'use_pagination' => get_field('use_pagination') ?? false,
            'ignore_sticky_posts' => get_field('ignore_sticky_posts') ?? false,
            'post_status' => 'publish',
            'paged' => get_field('use_pagination') ? (get_query_var('paged') ?: 1) : null,
        ];

        if ($postIn = get_field('post__in')) {
            $query['post__in'] = $postIn;
            $query['orderby'] = 'post__in';
            $query['order'] = 'ASC';
        } else {
            switch (get_field('event_state')) {
                case 'past':
                    $query['order'] = 'DESC';
                    $query['meta_query'][] = [
                        'key' => 'end_date',
                        'value' => date('Y-m-d H:i:s'),
                        'compare' => '<',
                        'type' => 'DATETIME'
                    ];
                    break;
                case 'upcoming':
                default:
                    $query['order'] = 'ASC';
                    $query['posts_per_page'] = -1;
                    $query['meta_query'][] = [
                        'key' => 'end_date',
                        'value' => date('Y-m-d H:i:s'),
                        'compare' => '>=',
                        'type' => 'DATETIME'
                    ];
                    break;
            }
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
}
