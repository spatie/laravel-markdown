<?php

namespace Spatie\LaravelMarkdown;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MarkdownServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-markdown')
            ->hasConfigFile()
            ->hasViews();

        Blade::component('markdown', MarkdownBladeComponent::class);

        $this->app->bind(MarkdownRenderer::class, function () {
            $config = config('markdown');

            /** @var \Spatie\LaravelMarkdown\MarkdownRenderer $renderer */
            $renderer = new $config['renderer_class'](
                commonmarkOptions: $config['commonmark_options'],
                highlightCode: $config['code_highlighting']['enabled'],
                highlightTheme: $config['code_highlighting']['theme'],
                cacheStoreName: $config['cache_store'],
                renderAnchors: $config['add_anchors_to_headings'],
                extensions: $config['extensions'],
                allowHTML: $config['allowHTML'],
                allowUnsafeLinks: $config['allowUnsafeLinks'],
            );

            foreach ($config['block_renderers'] as $blockRenderer) {
                $renderer->addBlockRenderer($blockRenderer['class'], $blockRenderer['renderer']);
            }

            return $renderer;
        });
    }
}
