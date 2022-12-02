<?php

use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

it('can use front matter extensions', function () {
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

    $renderedMarkdown = markdownRenderer()->convertToHtml($markdown);
    expect($renderedMarkdown)->toBeInstanceOf(RenderedContentWithFrontMatter::class);

    $frontMatter = $renderedMarkdown->getFrontMatter();
    expect([
        'extends' => 'post',
        'title' => 'My title',
    ])->toEqual($frontMatter);
    $html = $renderedMarkdown->getContent();
    expect($html)->toMatchSnapshot();
});

it('can parse many front matter variables', function () {
    // Add the extension on the fly to ensure addExtension is covered by tests too.
    $markdownRenderer = markdownRenderer()->addExtension(new FrontMatterExtension());

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
    expect($renderedMarkdown)->toBeInstanceOf(RenderedContentWithFrontMatter::class);

    $frontMatter = $renderedMarkdown->getFrontMatter();
    expect([
        'title' => 'Using FrontMatter with Laravel Blade',
        'description' => 'How to render FrontMatter & Blade with Spatie Markdown',
        'extends' => 'layouts.documentation',
        'section' => 'content',
        'food' => 'Pizza',
    ])->toEqual($frontMatter);
    $html = $renderedMarkdown->getContent();
    expect($html)->toMatchSnapshot();
});
