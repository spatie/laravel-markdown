<?php

namespace Spatie\LaravelMarkdown\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelMarkdown\MarkdownServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            MarkdownServiceProvider::class,
        ];
    }
}
