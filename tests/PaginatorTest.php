<?php

namespace SertxuDeveloper\Pagination\Tests;

use SertxuDeveloper\Pagination\Paginator;

class PaginatorTest extends TestCase
{
    public function testSimplePaginatorReturnsRelevantContextInformation() {
        $p = new Paginator(['item3', 'item4'], total: 5, perPage: 2, currentPage: 2);

        $this->assertEquals(2, $p->currentPage());
        $this->assertTrue($p->hasPages());
        $this->assertTrue($p->hasMorePages());
        $this->assertEquals(['item3', 'item4'], $p->items());

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

        $this->assertEquals($pageInfo, $p->toArray());
    }

    public function testPaginatorRemovesTrailingSlashes() {
        $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test/']);

        $this->assertSame('http://website.com/test?page=1', $p->previousPageUrl());
    }

    public function testPaginatorGeneratesUrlsWithoutTrailingSlash() {
        $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

        $this->assertSame('http://website.com/test?page=1', $p->previousPageUrl());
    }

    public function testItRetrievesThePaginatorOptions() {
        $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

        $this->assertSame(['path' => 'http://website.com/test'], $p->getOptions());
    }

    public function testPaginatorReturnsPath() {
        $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

        $this->assertSame('http://website.com/test', $p->path());
    }

    public function testCanTransformPaginatorItems() {
        $p = new Paginator(['item1', 'item2', 'item3'], total: 5, perPage: 2, currentPage: 2, options: ['path' => 'http://website.com/test']);

        $p->through(function ($item) {
            return substr($item, 4, 1);
        });

        $this->assertInstanceOf(Paginator::class, $p);
        $this->assertSame(['1', '2', '3'], $p->items());
    }
}
