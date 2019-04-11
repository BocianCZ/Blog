<?php

return [
    'blog.posts' => [
        'index' => 'blog::posts.index',
        'create' => 'blog::posts.create',
        'store' => 'blog::posts.store',
        'edit' => 'blog::posts.edit',
        'update' => 'blog::posts.update',
        'destroy' => 'blog::posts.destroy',
    ],
    'blog.categories' => [
        'index' => 'blog::categories.index',
        'create' => 'blog::categories.create',
        'store' => 'blog::categories.store',
        'edit' => 'blog::categories.edit',
        'update' => 'blog::categories.update',
        'destroy' => 'blog::categories.destroy',
    ],
    'blog.tags' => [
        'index' => 'blog::tags.index',
        'create' => 'blog::tags.create',
        'store' => 'blog::tags.store',
        'edit' => 'blog::tags.edit',
        'update' => 'blog::tags.update',
        'destroy' => 'blog::tags.destroy',
    ],
];
