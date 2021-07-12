<?php

namespace Spatie\LaravelMarkdown\Tests;

use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownRendererTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_render_markdown()
    {
        $markdown =  <<<MD
            # My title

            This is a [link to our website](https://spatie.be)

            ```php
            echo 'Hello world';
            ```
            MD;

        $html = $this->markdownRenderer()->toHtml($markdown);

        $this->assertMatchesSnapshot($html);
    }

    /** @test */
    public function it_can_disable_highlighting()
    {
        $markdown =  <<<MD
            # My title

            This is a [link to our website](https://spatie.be)

            ```php
            echo 'Hello world';
            ```
            MD;

        $html = $this
            ->markdownRenderer()
            ->disableHighlighting()
            ->toHtml($markdown);

        $this->assertMatchesSnapshot($html);
    }

    /** @test */
    public function it_can_use_an_alternative_highlighting_them()
    {
        $markdown =  <<<MD
            # My title

            This is a [link to our website](https://spatie.be)

            ```php
            echo 'Hello world';
            ```
            MD;

        $html = $this
            ->markdownRenderer()
            ->highlightTheme('github-dark')
            ->toHtml($markdown);

        $this->assertMatchesSnapshot($html);
    }

    /** @test */
    public function it_can_disable_rendering_anchors()
    {
        $markdown =  <<<MD
            # My title
            MD;

        $html = $this
            ->markdownRenderer()
            ->disableAnchors()
            ->toHtml($markdown);

        $this->assertMatchesSnapshot($html);
    }

    protected function markdownRenderer(): MarkdownRenderer
    {
        return app(MarkdownRenderer::class);
    }
}
