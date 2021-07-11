<?php

namespace Spatie\LaravelMarkdownBladeComponent;

use Spatie\LaravelMarkdownBladeComponent\Commands\LaravelMarkdownBladeComponentCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMarkdownBladeComponentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-markdown-blade-component')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-markdown-blade-component_table')
            ->hasCommand(LaravelMarkdownBladeComponentCommand::class);
    }
}
