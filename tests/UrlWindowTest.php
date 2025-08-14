<?php

namespace SertxuDeveloper\Pagination\Tests;

use PHPUnit\Framework\TestCase;
use SertxuDeveloper\Pagination\Paginator;
use SertxuDeveloper\Pagination\UrlWindow;

class UrlWindowTest extends TestCase
{
    public function test_presenter_can_determine_if_there_are_any_pages_to_show() {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], 4, 2, 2);
        $window = new UrlWindow($p);
        $this->assertTrue($window->hasPages());
    }

    public function test_presenter_can_get_a_url_range_for_a_small_number_of_urls() {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], 4, 2, 2);
        $window = new UrlWindow($p);
        $this->assertEquals(['first' => [1 => '/?page=1', 2 => '/?page=2'], 'slider' => null, 'last' => null], $window->get());
    }

    public function test_presenter_can_get_a_url_range_for_a_window_of_links() {
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

    public function test_custom_url_range_for_a_window_of_links() {
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
            'last' => null,
        ], $window->get());
    }

    public function test_presenter_can_get_a_url_range_too_close_to_beginning() {
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
            'last' => null,
        ], $window->get());
    }

    public function test_presenter_can_get_a_url_range_too_close_to_ending() {
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
            'last' => null,
        ], $window->get());
    }

    public function test_prevents_displaying_slider_if_no_pages_available() {
        $p = new Paginator($array = ['item1', 'item2', 'item3', 'item4'], count($array), 4, 1);
        $p->onEachSide(0);
        $window = new UrlWindow($p);

        $this->assertEquals([
            'first' => null,
            'slider' => null,
            'last' => null,
        ], $window->get());
    }
}
