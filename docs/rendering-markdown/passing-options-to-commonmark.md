---
title: Passing options to Commonmark
weight: 4
---

Under the hood, the `league/commonmark` package is used to render markdown. In the `commonmark_options` key of the `markdown` config file, you can pass any of the options mentioned in [the league/commonmark docs](https://commonmark.thephpleague.com/1.6/configuration/).

Alternatively, you can pass options to the `commonmarkOptions()` method.

```php
$html = app(Spatie\LaravelMarkdown\MarkdownRenderer::class)
    ->commonmarkOptions($arrayWithOptions)
    ->toHtml($markdown);
```
