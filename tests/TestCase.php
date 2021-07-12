<?php

namespace Spatie\LaravelMarkdown\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelMarkdown\MarkdownBladeComponentServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            MarkdownBladeComponentServiceProvider::class,
        ];
    }
}
