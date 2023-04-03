<?php

namespace App\Blocks;

use Genero\Sage\CacheTags\Tags\CoreTags;

class ProductList extends ArticleList
{
    public $name = 'Product List';
    public $description = 'Show a list of articles...';
    public $keywords = ['tuotteet'];

    public $styles = [
        [
            'name' => 'default',
            'label' => 'Grid',
            'isDefault' => true,
        ],
        [
            'name' => 'mobile-carousel',
            'label' => 'Mobile Carousel',
        ],
    ];

    public function buildQuery(): array
    {
        $query = [
            'posts_per_page' => (int) get_field('posts_per_page') ?: 3,
            'order_by' => get_field('order_by') ?: ['date'],
            'order' => get_field('order') ?: 'DESC',
            'post_type' => 'product',
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
                'taxonomy' => 'product_cat',
                'terms' => $categories,
            ];
        }

        return $query;
    }

    public function cacheTags(): array
    {
        if (empty($this->buildQuery()['post__in'])) {
            return [
                ...CoreTags::archive('product'),
            ];
        }
        return [];
    }
}
