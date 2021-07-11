<?php

namespace Spatie\MarkdownBladeComponent;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarkdownBladeComponent extends Component
{
    public function __construct(
        protected ?bool $highlightCode = null,
        protected ?string $theme = null,
    )
    {
    }

    public function convertToHtml(string $markdown): string
    {
        $markdownRenderer = new MarkdownRenderer(
            highlightCode: $this->highlightCode ?? config('markdown-blade-component.code_highlighting.enabled'),
            highlightTheme: $this->theme ?? config('markdown-blade-component.code_highlighting.theme'),
            cacheStoreName: config('markdown-blade-component.cache_store')
        );

        return $markdownRenderer->convertToHtml($markdown);
    }

    public function render(): View
    {
        return view('markdown-blade-component::markdown');
    }
}
