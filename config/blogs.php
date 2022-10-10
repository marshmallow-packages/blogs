<?php

return [

    'publish_date_format' => 'd M',

    'model' => [
        'blog' => \Marshmallow\Blogs\Models\Blog::class,
        'blog_tags' => \Marshmallow\Blogs\Models\BlogTag::class,
        'user' => \App\Models\User::class,
    ],

    'nova' => [
        'blog_tags' => \Marshmallow\Blogs\Nova\BlogTag::class,
        'user' => \App\Nova\User::class,
    ],

    'images' => [
        'image' => [1920, 800],
        'overview_image' => [500, 280],
        'detail_image' => [900, 450],
    ],

    'routes' => [
        'blog' => 'blog-detail',
        'blog_tags' => 'blog-tag',
    ],

    'page_route_names' => [
        'blog' => 'blog-detail-page',
        'blog_tags' => 'blog-tag-page',
    ],
];
