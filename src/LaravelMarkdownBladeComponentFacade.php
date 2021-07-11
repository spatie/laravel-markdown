<?php

namespace Spatie\LaravelMarkdownBladeComponent;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\LaravelMarkdownBladeComponent\LaravelMarkdownBladeComponent
 */
class LaravelMarkdownBladeComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-markdown-blade-component';
    }
}
