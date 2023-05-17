<?php

namespace SertxuDeveloper\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void {
        $this->defineAssetPublishing();
        $this->offerPublishing();
    }

    /**
     * Define the asset publishing configuration.
     */
    public function defineAssetPublishing(): void {
        $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'pagination');
    }

    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(
            abstract: LengthAwarePaginator::class,
            concrete: Paginator::class
        );
    }

    /**
     * Set up the resource publishing groups.
     */
    protected function offerPublishing(): void {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__).'/resources/views' => resource_path('views/vendor/pagination'),
            ], ['views', 'pagination-views']);
        }
    }
}
