<?php

namespace FilipFonal\FilamentLogManager\Tests;

use FilipFonal\FilamentLogManager\FilamentLogManagerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentLogManagerServiceProvider::class,
        ];
    }
}
