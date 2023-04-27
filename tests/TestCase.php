<?php

namespace SertxuDeveloper\Pagination\Tests;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\Pagination\PaginationServiceProvider;
use SertxuDeveloper\Pagination\Tests\Models\User;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class TestCase extends Orchestra
{
    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations(): void {
        $this->loadLaravelMigrations();
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array {
        return [
            PaginationServiceProvider::class,
        ];
    }

    /**
     * Define routes setup.
     *
     * @param  Router  $router
     */
    protected function defineRoutes($router): void {
        $router->get('users', fn () => User::query()->paginate(10))->name('users.index');
    }
}
