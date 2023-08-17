<?php

namespace Spatie\LaravelMarkdown;

use Illuminate\View\Compilers\BladeCompiler;
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

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->component('markdown', MarkdownBladeComponent::class);

            $echoMarkdown = 'echo app()->make(\\' . MarkdownRenderer::class . '::class)->toHtml';
            $bladeCompiler->directive('markdown', fn ($markdown) => '<?php ' . ($markdown ? "{$echoMarkdown}({$markdown})" : 'ob_start()') . '; ?>');
            $bladeCompiler->directive('endmarkdown', fn () => "<?php {$echoMarkdown}(ob_get_clean()); ?>");
        });

        $this->app->bind(MarkdownRenderer::class, function () {
            $config = config('markdown');

            /** @var \Spatie\LaravelMarkdown\MarkdownRenderer $renderer */
            return new $config['renderer_class'](
                commonmarkOptions: $config['commonmark_options'],
                highlightCode: $config['code_highlighting']['enabled'],
                highlightTheme: $config['code_highlighting']['theme'],
                cacheStoreName: $config['cache_store'],
                renderAnchors: $config['add_anchors_to_headings'],
                renderAnchorsAsLinks: $config['render_anchors_as_links'],
                extensions: $config['extensions'],
                blockRenderers: $config['block_renderers'],
                inlineRenderers: $config['inline_renderers'],
                inlineParsers: $config['inline_parsers'],
            );
        });
    }
}
