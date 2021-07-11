<?php

namespace Spatie\MarkdownBladeComponent;

use Illuminate\View\Component;

class MarkdownBladeComponent extends Component
{
    public function __construct(
        protected ?bool $highlightCode = null,
        protected ?string $theme = null,
    ) {
    }

    public function convertToHtml(string $markdown): string
    {
        $markdownRenderer = new MarkdownRenderer(
            $this->highlightCode,
            $this->theme,
            config('markdown-blade-component')
        );

        return $markdownRenderer->convertToHtml($markdown);
    }

    public function render()
    {
        return view('markdown-blade-component::markdown');
    }
}
