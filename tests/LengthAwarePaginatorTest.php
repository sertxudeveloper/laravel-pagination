<?php

use SertxuDeveloper\Pagination\Paginator;

beforeEach(function () {
    $this->opts = ['onEachSide' => 5];
    $this->p = new Paginator(['item1', 'item2', 'item3', 'item4'], 4, 2, 2, $this->opts);
});

afterEach(function () {
    unset($this->p);
});

test('length aware paginator get and set page name', function () {
    expect($this->p->getPageName())->toBe('page');

    $this->p->setPageName('p');
    expect($this->p->getPageName())->toBe('p');
});

test('length aware paginator can give me relevant page information', function () {
    expect($this->p->lastPage())->toBe(2);
    expect($this->p->currentPage())->toBe(2);
    expect($this->p->hasPages())->toBeTrue();
    expect($this->p->hasMorePages())->toBeFalse();
    expect($this->p->items())->toBe(['item1', 'item2', 'item3', 'item4']);
});

test('length aware paginator set correct information with no items', function () {
    $paginator = new Paginator([], 0, 2, 1);

    expect($paginator->lastPage())->toBe(1);
    expect($paginator->currentPage())->toBe(1);
    expect($paginator->hasPages())->toBeFalse();
    expect($paginator->hasMorePages())->toBeFalse();
    expect($paginator->items())->toBeEmpty();
});

test('length aware paginator is on first and last page', function () {
    $paginator = new Paginator(['1', '2', '3', '4'], 4, 2, 2);

    expect($paginator->onLastPage())->toBeTrue();
    expect($paginator->onFirstPage())->toBeFalse();

    $paginator = new Paginator(['1', '2', '3', '4'], 4, 2, 1);

    expect($paginator->onLastPage())->toBeFalse();
    expect($paginator->onFirstPage())->toBeTrue();
});

test('length aware paginator can generate urls', function () {
    $this->p->setPath('http://website.com');
    $this->p->setPageName('foo');

    expect($this->p->path())->toBe('http://website.com');

    expect($this->p->url($this->p->currentPage()))->toBe('http://website.com?foo=2');

    expect($this->p->url($this->p->currentPage() - 1))->toBe('http://website.com?foo=1');

    expect($this->p->url($this->p->currentPage() - 2))->toBe('http://website.com?foo=1');
});

test('length aware paginator can generate urls with query', function () {
    $this->p->setPath('http://website.com?sort_by=date');
    $this->p->setPageName('foo');

    expect($this->p->url($this->p->currentPage()))->toBe('http://website.com?sort_by=date&foo=2');
});

test('length aware paginator can generate urls without trailing slashes', function () {
    $this->p->setPath('http://website.com/test');
    $this->p->setPageName('foo');

    expect($this->p->url($this->p->currentPage()))->toBe('http://website.com/test?foo=2');

    expect($this->p->url($this->p->currentPage() - 1))->toBe('http://website.com/test?foo=1');

    expect($this->p->url($this->p->currentPage() - 2))->toBe('http://website.com/test?foo=1');
});

test('length aware paginator correctly generate urls with query and spaces', function () {
    $this->p->setPath('http://website.com?key=value%20with%20spaces');
    $this->p->setPageName('foo');

    expect($this->p->url($this->p->currentPage()))->toBe('http://website.com?key=value%20with%20spaces&foo=2');
});

test('it retrieves the paginator options', function () {
    expect($this->p->getOptions())->toBe($this->opts);
});
