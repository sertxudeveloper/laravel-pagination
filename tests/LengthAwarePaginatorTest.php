<?php

namespace SertxuDeveloper\Pagination\Tests;

use SertxuDeveloper\Pagination\Paginator;

class LengthAwarePaginatorTest extends TestCase
{
    private Paginator $p;

    private array $options;

    protected function setUp(): void {
        $this->options = ['onEachSide' => 5];
        $this->p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], 4, 2, 2, $this->options);
    }

    protected function tearDown(): void {
        unset($this->p);
    }

    public function test_length_aware_paginator_get_and_set_page_name() {
        $this->assertSame('page', $this->p->getPageName());

        $this->p->setPageName('p');
        $this->assertSame('p', $this->p->getPageName());
    }

    public function test_length_aware_paginator_can_give_me_relevant_page_information() {
        $this->assertEquals(2, $this->p->lastPage());
        $this->assertEquals(2, $this->p->currentPage());
        $this->assertTrue($this->p->hasPages());
        $this->assertFalse($this->p->hasMorePages());
        $this->assertEquals(['item1', 'item2', 'item3', 'item4'], $this->p->items());
    }

    public function test_length_aware_paginator_set_correct_information_with_no_items() {
        $paginator = new Paginator([], 0, 2, 1);

        $this->assertEquals(1, $paginator->lastPage());
        $this->assertEquals(1, $paginator->currentPage());
        $this->assertFalse($paginator->hasPages());
        $this->assertFalse($paginator->hasMorePages());
        $this->assertEmpty($paginator->items());
    }

    public function test_length_aware_paginatoris_on_first_and_last_page() {
        $paginator = new Paginator(['1', '2', '3', '4'], 4, 2, 2);

        $this->assertTrue($paginator->onLastPage());
        $this->assertFalse($paginator->onFirstPage());

        $paginator = new Paginator(['1', '2', '3', '4'], 4, 2, 1);

        $this->assertFalse($paginator->onLastPage());
        $this->assertTrue($paginator->onFirstPage());
    }

    public function test_length_aware_paginator_can_generate_urls() {
        $this->p->setPath('http://website.com');
        $this->p->setPageName('foo');

        $this->assertSame(
            'http://website.com',
            $this->p->path()
        );

        $this->assertSame(
            'http://website.com?foo=2',
            $this->p->url($this->p->currentPage())
        );

        $this->assertSame(
            'http://website.com?foo=1',
            $this->p->url($this->p->currentPage() - 1)
        );

        $this->assertSame(
            'http://website.com?foo=1',
            $this->p->url($this->p->currentPage() - 2)
        );
    }

    public function test_length_aware_paginator_can_generate_urls_with_query() {
        $this->p->setPath('http://website.com?sort_by=date');
        $this->p->setPageName('foo');

        $this->assertSame(
            'http://website.com?sort_by=date&foo=2',
            $this->p->url($this->p->currentPage())
        );
    }

    public function test_length_aware_paginator_can_generate_urls_without_trailing_slashes() {
        $this->p->setPath('http://website.com/test');
        $this->p->setPageName('foo');

        $this->assertSame(
            'http://website.com/test?foo=2',
            $this->p->url($this->p->currentPage())
        );

        $this->assertSame(
            'http://website.com/test?foo=1',
            $this->p->url($this->p->currentPage() - 1)
        );

        $this->assertSame(
            'http://website.com/test?foo=1',
            $this->p->url($this->p->currentPage() - 2)
        );
    }

    public function test_length_aware_paginator_correctly_generate_urls_with_query_and_spaces() {
        $this->p->setPath('http://website.com?key=value%20with%20spaces');
        $this->p->setPageName('foo');

        $this->assertSame(
            'http://website.com?key=value%20with%20spaces&foo=2',
            $this->p->url($this->p->currentPage())
        );
    }

    public function test_it_retrieves_the_paginator_options() {
        $this->assertSame($this->options, $this->p->getOptions());
    }
}
