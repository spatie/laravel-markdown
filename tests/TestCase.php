<?php

namespace Spatie\MarkdownBladeComponent\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MarkdownBladeComponent\MarkdownBladeComponentServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            MarkdownBladeComponentServiceProvider::class,
        ];
    }
}
