---
title: General usage
weight: 1
---

You can render any markdown by resolving `Spatie\LaravelMarkdown\MarkdownRenderer` out of the container and calling `toHtml`. By resolving the class out of the container all options of the config file will be used.

```php
$html = app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($markdown);
```

