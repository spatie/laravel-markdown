<?php

namespace Spatie\MarkdownBladeComponent;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarkdownBladeComponent extends Component
{
    public function __construct(
        protected ?array $options = [],
        protected ?bool $highlightCode = null,
        protected ?string $theme = null,
        protected ?bool $anchors = null,
    ) {
    }

    public function convertToHtml(string $markdown): string
    {
        $config = config('markdown-blade-component');

        $markdownRenderer = new $config['renderer_class'](
            commonmarkOptions: array_merge($config['commonmark_options'], $this->options),
            highlightCode: $this->highlightCode ?? $config['code_highlighting']['enabled'],
            highlightTheme: $this->theme ?? $config['code_highlighting']['theme'],
            cacheStoreName: $config['cache_store'],
            renderAnchors: $this->anchors ?? $config['add_anchors_to_headings'],
        );

        return $markdownRenderer->convertToHtml($markdown);
    }

    public function render(): View
    {
        return view('markdown-blade-component::markdown');
    }
}
