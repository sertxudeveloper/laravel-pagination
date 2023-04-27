<?php

namespace SertxuDeveloper\Pagination;

use Illuminate\Pagination\LengthAwarePaginator as IlluminateLengthAwarePaginator;

class Paginator extends IlluminateLengthAwarePaginator
{
    /**
     * The number of links to display on each side of current page link.
     *
     * @var int
     */
    public $onEachSide = 2;

    /**
     * Get the array of elements to pass to the view.
     */
    protected function elements(): array {
        $window = UrlWindow::make($this);

        return array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }
}
