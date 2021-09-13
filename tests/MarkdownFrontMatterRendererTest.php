<?php

namespace Spatie\LaravelMarkdown\Tests;

use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownFrontMatterRendererTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_use_front_matter_extensions()
    {
        config()->set('markdown.extensions', [
            FrontMatterExtension::class,
        ]);

        $markdown = <<<EOT
---
extends: post
title: My title
---
# My title

This is a [link to our website](https://spatie.be)

```php
echo 'Hello world';
```
EOT;

        $renderedMarkdown = $this
           ->markdownRenderer()
           ->convertToHtml($markdown);
        $this->assertInstanceOf(RenderedContentWithFrontMatter::class, $renderedMarkdown);

        $frontMatter = $renderedMarkdown->getFrontMatter();
        $this->assertEquals([
            'extends' => 'post',
            'title' => 'My title',
        ], $frontMatter);
        $html = $renderedMarkdown->getContent();
        $this->assertMatchesSnapshot($html);
    }

    /** @test */
    public function it_can_parse_many_front_matter_variables()
    {
        // Add the extension on the fly to ensure addExtension is covered by tests too.
        $markdownRenderer = $this->markdownRenderer()->addExtension(new FrontMatterExtension());

        $markdown = <<<EOT
---
title: Using FrontMatter with Laravel Blade
description: How to render FrontMatter & Blade with Spatie Markdown
extends: layouts.documentation
section: content
food: Pizza
---
# Using FrontMatter with Laravel Blade

This is a [link to our website](https://spatie.be).

The content here would be rendered by markdown first - then you would get the FrontMatter metadata and render it again.
This time by rendering the template defined in extends, and the HTML content rendered by markdown into the defined section.
EOT;

        $renderedMarkdown = $markdownRenderer
            ->convertToHtml($markdown);
        $this->assertInstanceOf(RenderedContentWithFrontMatter::class, $renderedMarkdown);

        $frontMatter = $renderedMarkdown->getFrontMatter();
        $this->assertEquals([
            'title' => 'Using FrontMatter with Laravel Blade',
            'description' => 'How to render FrontMatter & Blade with Spatie Markdown',
            'extends' => 'layouts.documentation',
            'section' => 'content',
            'food' => 'Pizza',
        ], $frontMatter);
        $html = $renderedMarkdown->getContent();
        $this->assertMatchesSnapshot($html);
    }

    protected function markdownRenderer(): MarkdownRenderer
    {
        return app(MarkdownRenderer::class);
    }
}
