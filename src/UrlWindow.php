<?php

namespace SertxuDeveloper\Pagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginatorContract;

class UrlWindow
{
    /**
     * The paginator implementation.
     *
     * @var PaginatorContract
     */
    protected PaginatorContract $paginator;

    /**
     * Create a new URL window instance.
     *
     * @param PaginatorContract $paginator
     * @return void
     */
    public function __construct(PaginatorContract $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Create a new URL window instance.
     *
     * @param PaginatorContract $paginator
     * @return array
     */
    public static function make(PaginatorContract $paginator): array
    {
        return (new static($paginator))->get();
    }

    /**
     * Get the window of URLs to be shown.
     *
     * @return array
     */
    public function get(): array
    {
        $onEachSide = $this->paginator->onEachSide;

        if ($this->paginator->lastPage() < ($onEachSide * 2)) {
            return $this->getSmallSlider();
        }

        return $this->getUrlSlider($onEachSide);
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * Get the slider of URLs there are not enough pages to slide.
     *
     * @return array
     */
    protected function getSmallSlider(): array
    {
        return [
            'first' => $this->paginator->getUrlRange(1, $this->lastPage()),
            'slider' => null,
            'last' => null,
        ];
    }

    /**
     * Create a URL slider links.
     *
     * @param int $onEachSide
     * @return array
     */
    protected function getUrlSlider(int $onEachSide): array
    {
        if (!$this->hasPages()) {
            return ['first' => null, 'slider' => null, 'last' => null];
        }

        // If the current page is very close to the beginning of the page range, we will
        // just render the beginning of the page range, followed by the last 2 of the
        // links in this list, since we will not have room to create a full slider.
        if ($this->currentPage() <= $onEachSide) {
            return $this->getSliderTooCloseToBeginning(onEachSide: $onEachSide);
        }

        // If the current page is close to the ending of the page range we will just get
        // this first couple pages, followed by a larger window of these ending pages
        // since we're too close to the end of the list to create a full on slider.
        elseif ($this->currentPage() > ($this->lastPage() - $onEachSide)) {
            return $this->getSliderTooCloseToEnding(onEachSide: $onEachSide);
        }

        // If we have enough room on both sides of the current page to build a slider we
        // will surround it with both the beginning and ending caps, with this window
        // of pages in the middle providing a Google style sliding paginator setup.
        return $this->getFullSlider($onEachSide);
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages(): bool
    {
        return $this->paginator->lastPage() > 1;
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the slider of URLs when too close to the beginning of the window.
     *
     * @param int $onEachSide
     * @return array
     */
    protected function getSliderTooCloseToBeginning(int $onEachSide): array
    {
        return [
            'first' => $this->paginator->getUrlRange(start: 1, end: $onEachSide * 2 + 1),
            'slider' => null,
            'last' => null,
        ];
    }

    /**
     * Get the slider of URLs when too close to the ending of the window.
     *
     * @param int $onEachSide
     * @return array
     */
    protected function getSliderTooCloseToEnding(int $onEachSide): array
    {
        $start = $this->lastPage() - ($onEachSide * 2);

        return [
            'first' => $this->paginator->getUrlRange(start: $start, end: $this->lastPage()),
            'slider' => null,
            'last' => null,
        ];
    }

    /**
     * Get the slider of URLs when a full slider can be made.
     *
     * @param int $onEachSide
     * @return array
     */
    protected function getFullSlider(int $onEachSide): array
    {
        return [
            'first' => $this->getAdjacentUrlRange($onEachSide),
            'slider' => null,
            'last' => null,
        ];
    }

    /**
     * Get the page range for the current page window.
     *
     * @param int $onEachSide
     * @return array
     */
    public function getAdjacentUrlRange(int $onEachSide): array
    {
        return $this->paginator->getUrlRange(
            $this->currentPage() - $onEachSide,
            $this->currentPage() + $onEachSide
        );
    }
}
