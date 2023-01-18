---
title: Introduction
weight: 1
---

This package contains:

- a Blade component that can render markdown
- a highly configurable class that you can use to render markdown

Let's start with an example of the provided `x-markdown` Blade component. This chunk of markdown...

````blade
<x-markdown>
# My title

This is a [link to our website](https://spatie.be)

```php
echo 'Hello world';
```
</x-markdown>
````

... will be converted to this chunk of HTML:

```html
<div>
    <h1 id="my-title">My title</h1>
    <p>This is a <a href="https://spatie.be">link to our website</a></p>
    <pre class="shiki" style="background-color: #fff"><code><span class="line"><span
        style="color: #005CC5">echo</span><span style="color: #24292E"> </span><span style="color: #032F62">&#39;Hello world&#39;</span><span
        style="color: #24292E">;</span></span>
<span class="line"></span></code></pre>
</div>
```

You can also programmatically render HTML.

```php
// by resolving the class out of the container all the options
// in the config file will be used.

app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($markdown);
```

Out of the box, the `x-markdown` component or `MarkdownRenderer` can:

- highlight code blocks correctly (via [Shiki PHP](https://github.com/spatie/shiki-php)) for 100+ languages, including PHP, JS, Blade, [and many more](https://github.com/shikijs/shiki/blob/main/docs/languages.md).
- add anchor links to headings
- cache results to increase performance

## We have badges!

<section class="article_badges">
    <a href="https://github.com/spatie/laravel-markdown/releases"><img src="https://img.shields.io/github/release/spatie/laravel-markdown.svg?style=flat-square" alt="Latest Version"></a>
    <a href="https://github.com/spatie/laravel-markdown/blob/main/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://packagist.org/packages/spatie/laravel-markdown"><img src="https://img.shields.io/packagist/dt/spatie/laravel-markdown.svg?style=flat-square" alt="Total Downloads"></a>
</section>
