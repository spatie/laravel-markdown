<?php

namespace Spatie\MarkdownBladeComponent\Tests;

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
