<?php

use SertxuDeveloper\Pagination\Paginator;

test('simple paginator returns relevant context information', function () {
    $p = new Paginator(['item3', 'item4'], total: 5, perPage: 2, currentPage: 2);

    expect($p->currentPage())->toBe(2);
    expect($p->hasPages())->toBeTrue();
    expect($p->hasMorePages())->toBeTrue();
    expect($p->items())->toBe(['item3', 'item4']);

    $pageInfo = [
        'per_page' => 2,
        'current_page' => 2,
        'first_page_url' => '/?page=1',
        'next_page_url' => '/?page=3',
        'prev_page_url' => '/?page=1',
        'from' => 3,
        'to' => 4,
        'data' => ['item3', 'item4'],
        'path' => '/',
        'last_page' => 3,
        'last_page_url' => '/?page=3',
        'links' => [
            [
                'url' => '/?page=1',
                'label' => '&laquo; Previous',
                'active' => false,
            ],
            [
                'url' => '/?page=1',
                'label' => 1,
                'active' => false,
            ],
            [
                'url' => '/?page=2',
                'label' => '2',
                'active' => true,
            ],
            [
                'url' => '/?page=3',
                'label' => '3',
                'active' => false,
            ],
            [
                'url' => '/?page=3',
                'label' => 'Next &raquo;',
                'active' => false,
            ],
        ],
        'total' => 5,
    ];

    expect($p->toArray())->toEqual($pageInfo);
});

test('paginator removes trailing slashes', function () {
    $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test/']);

    expect($p->previousPageUrl())->toBe('http://website.com/test?page=1');
});

test('paginator generates urls without trailing slash', function () {
    $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

    expect($p->previousPageUrl())->toBe('http://website.com/test?page=1');
});

test('it retrieves the paginator options', function () {
    $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

    expect($p->getOptions())->toBe(['path' => 'http://website.com/test']);
});

test('paginator returns path', function () {
    $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

    expect($p->path())->toBe('http://website.com/test');
});

test('can transform paginator items', function () {
    $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

    $p->through(function ($item) {
        return substr($item, 4, 1);
    });

    expect($p)->toBeInstanceOf(Paginator::class);
    expect($p->items())->toBe(['1', '2', '3']);
});
