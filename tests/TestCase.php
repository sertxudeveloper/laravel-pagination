<?php

namespace SertxuDeveloper\Pagination\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\Pagination\PaginationServiceProvider;
use SertxuDeveloper\Pagination\Tests\Models\User;

class TestCase extends Orchestra
{
    protected function defineDatabaseMigrations(): void {
        $this->loadLaravelMigrations();
    }

    protected function getPackageProviders($app): array {
        return [
            PaginationServiceProvider::class,
        ];
    }

    protected function defineRoutes($router): void {
        $router->get('users', fn () => User::query()->paginate(10))->name('users.index');
    }
}
