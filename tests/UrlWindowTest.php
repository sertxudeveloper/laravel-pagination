<?php

namespace SertxuDeveloper\Pagination\Tests;

use PHPUnit\Framework\TestCase;
use SertxuDeveloper\Pagination\Paginator;
use SertxuDeveloper\Pagination\UrlWindow;

class UrlWindowTest extends TestCase
{
    public function testPresenterCanDetermineIfThereAreAnyPagesToShow()
    {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], 4, 2, 2);
        $window = new UrlWindow($p);
        $this->assertTrue($window->hasPages());
    }

    public function testPresenterCanGetAUrlRangeForASmallNumberOfUrls()
    {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], 4, 2, 2);
        $window = new UrlWindow($p);
        $this->assertEquals(['first' => [1 => '/?page=1', 2 => '/?page=2'], 'slider' => null, 'last' => null], $window->get());
    }

    public function testPresenterCanGetAUrlRangeForAWindowOfLinks()
    {
        $array = [];
        for ($i = 1; $i <= 20; $i++) {
            $array[$i] = 'item'.$i;
        }
        $p = new Paginator($array, count($array), 1, 12);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => [
                10 => '/?page=10',
                11 => '/?page=11',
                12 => '/?page=12',
                13 => '/?page=13',
                14 => '/?page=14',
            ],
            'slider' => null,
            'last' => null,
        ], $window->get());

        /*
         * Test Being Near The End Of The List
         */
        $array = [];
        for ($i = 1; $i <= 20; $i++) {
            $array[$i] = 'item'.$i;
        }
        $p = new Paginator($array, count($array), 1, 17);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => [
                15 => '/?page=15',
                16 => '/?page=16',
                17 => '/?page=17',
                18 => '/?page=18',
                19 => '/?page=19',
            ],
            'slider' => null,
            'last' => null,
        ], $window->get());
    }

    public function testCustomUrlRangeForAWindowOfLinks()
    {
        $array = [];
        for ($i = 1; $i <= 20; $i++) {
            $array[$i] = 'item'.$i;
        }

        $p = new Paginator($array, count($array), 1, 8);
        $p->onEachSide(1);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => [
                7 => '/?page=7',
                8 => '/?page=8',
                9 => '/?page=9',
            ],
            'slider' => null,
            'last' => null
        ], $window->get());
    }

    public function testPresenterCanGetAUrlRangeTooCloseToBeginning()
    {
        $p = new Paginator($array = ['item5', 'item6', 'item7', 'item8'], 40, 4, 2);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => [
                1 => '/?page=1',
                2 => '/?page=2',
                3 => '/?page=3',
                4 => '/?page=4',
                5 => '/?page=5',
            ],
            'slider' => null,
            'last' => null
        ], $window->get());
    }

    public function testPresenterCanGetAUrlRangeTooCloseToEnding()
    {
        $p = new Paginator($array = ['item5', 'item6', 'item7', 'item8'], 40, 4, 9);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => [
                6 => '/?page=6',
                7 => '/?page=7',
                8 => '/?page=8',
                9 => '/?page=9',
                10 => '/?page=10',
            ],
            'slider' => null,
            'last' => null
        ], $window->get());
    }

    public function testPreventsDisplayingSliderIfNoPagesAvailable()
    {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], count($array), 4, 1);
        $p->onEachSide(0);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => null,
            'slider' => null,
            'last' => null
        ], $window->get());
    }
}
