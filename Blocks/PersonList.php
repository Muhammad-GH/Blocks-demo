<?php

namespace App\Blocks;

use Genero\Sage\CacheTags\Tags\CoreTags;
use stdClass;
use WP_Post;

class PersonList extends ArticleList
{
    public $name = 'Person List';
    public $description = 'Show a list of people...';
    public $keywords = ['contact'];
    public $styles = [];

    public function with()
    {
        return array_merge(parent::with(), [
            'use_filters' => get_field('use_filters'),
            'grouped' => $this->groupedPeople(),
            'count' => $this->peopleCount(),
        ]);
    }

    public function peopleCount(): ?int
    {
        if (!get_field('use_filters')) {
            return null;
        }

        return $this->query()->post_count;
    }

    public function groupedPeople(): ?array
    {
        if (!get_field('use_filters')) {
            return null;
        }

        $people = $this->query()->get_posts();

        return collect($people)
            ->map(function (WP_Post $post) {
                return (object) [
                    'post' => $post,
                    'department' => get_the_terms($post, 'department')[0] ?? null,
                ];
            })
            ->sortBy(function (stdClass $obj) {
                return get_term_meta($obj->department->term_id, 'tax_position', true);
            })
            ->groupBy(function (stdClass $obj) {
                return $obj->department->name ?? '';
            })
            ->toArray();
    }

    public function buildQuery(): array
    {
        $query = [
            'posts_per_page' => -1,
            'post_type' => 'person',
            'use_pagination' => false,
            'post_status' => 'publish',
            'meta_query' => [
                'last_name' => [
                    'key' => 'last_name',
                    'compare' => 'EXISTS'
                ],
                'first_name' => [
                    'key' => 'first_name',
                    'compare' => 'EXISTS'
                ],
            ],
            'orderby' => [
                'menu_order' => 'ASC'
            ]

        ];

        if ($postIn = get_field('post__in')) {
            $query['post__in'] = $postIn;
            $query['orderby'] = 'post__in';
            $query['order'] = 'ASC';
        }

        if ($categories = get_field('category')) {
            $query['tax_query'][] = [
                'taxonomy' => 'department',
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
