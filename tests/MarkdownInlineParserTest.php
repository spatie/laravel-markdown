<?php

namespace Spatie\LaravelMarkdown\Tests;


use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\LaravelMarkdown\Tests\Stubs\CustomInlineParser;

class MarkdownInlineParserTest extends TestCase
{

    /** @test */
    public function it_can_use_custom_inline_parser()
    {
        config()->set('markdown.inline_parsers', [
            ['parser' => new CustomInlineParser(), 'priority' => 0]
        ]);

        $markdown = <<<MD
            I am a text with a very randomly placed @ symbol in the middle.
           MD;

        $html = $this
            ->markdownRenderer()
            ->disableAnchors()
            ->toHtml($markdown);

        $this->assertEquals('<p>I am a text with a very randomly placed THIS-REPLACED-THE-SYMBOL symbol in the middle.</p>' . PHP_EOL, $html);
    }

    protected function markdownRenderer(): MarkdownRenderer
    {
        return app(MarkdownRenderer::class);
    }

}
