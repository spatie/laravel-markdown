<?php

namespace Spatie\LaravelMarkdown;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarkdownBladeComponent extends Component
{
    public function __construct(
        protected ?array $options = [],
        protected ?bool $highlightCode = null,
        protected ?string $theme = null,
        protected ?bool $anchors = null,
        protected ?bool $anchorsLinks = null,
    ) {
    }

    public function toHtml(string $markdown): string
    {
        $config = config('markdown');

        $markdownRenderer = new $config['renderer_class'](
            commonmarkOptions: array_merge($config['commonmark_options'], $this->options),
            highlightCode: $this->highlightCode ?? $config['code_highlighting']['enabled'],
            highlightTheme: $this->theme ?? $config['code_highlighting']['theme'],
            cacheStoreName: $config['cache_store'],
            renderAnchors: $this->anchors ?? $config['add_anchors_to_headings'],
            renderAnchorsAsLinks: $this->anchorsLinks ?? $config['render_anchors_as_links'],
            extensions: $config['extensions'],
            blockRenderers: $config['block_renderers'],
            inlineRenderers: $config['inline_renderers'],
            inlineParsers: $config['inline_parsers'],
        );

        return $markdownRenderer->toHtml($markdown);
    }

    public function render(): View
    {
        return view('markdown::markdown');
    }
}
