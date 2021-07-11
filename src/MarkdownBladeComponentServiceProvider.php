<?php

namespace Spatie\MarkdownBladeComponent;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MarkdownBladeComponentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-markdown-blade-component')
            ->hasConfigFile()
            ->hasViews();

        Blade::component('markdown', MarkdownBladeComponent::class);
    }
}
