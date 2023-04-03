<?php

namespace App\Blocks;

use Genero\Sage\CacheTags\Concerns\BlockCacheTags;
use Genero\Sage\CacheTags\Tags\CoreTags;
use WP_Post;

class FeaturedArticle extends Block
{
    use BlockCacheTags;

    public $name = 'Featured Article';
    public $description = 'Show a featured article';
    public $category = 'widgets';
    public $icon = 'format-aside';
    public $keywords = ['news', 'uutiset', 'artikkelit'];
    public $mode = 'auto';
    public $align = 'full';
    public $supports = [
        'align' => ['full', 'wide'],
        'mode' => false,
    ];

    public function with()
    {
        return [
            'featured_post' => $this->featuredPost(),
        ];
    }

    public function featuredPost(): ?WP_Post
    {
        if ($postId = get_field('featured_post')) {
            return get_post(reset($postId));
        }

        return null;
    }
    public function render($block, $content = '', $preview = false, $post = 0)
    {
        if (!$this->featuredPost()) {
            if (is_bool($preview) && $preview) {
                return '<div class="acf-block-placeholder text-center">' . __('No results found...') . '</div>';
            }
            return '';
        }

        return parent::render(...func_get_args());
    }

    public function cacheTags(): array
    {
        return [
            ...CoreTags::posts($this->featuredPost()),
        ];
    }
}
