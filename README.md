# A highly configurable markdown renderer and Blade component for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-markdown.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown/run-tests?label=tests)](https://github.com/spatie/laravel-markdown/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-markdown/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-markdown.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown)

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

... will be converted by to component to this chunk of HTML:

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

Out of the box, the `x-markdown` component and `MarkdownRenderer` can:

- highlight code blocks correctly (via [Shiki PHP](https://github.com/spatie/shiki-php)) for 100+ languages, including PHP, JS, Blade, [and many more](https://github.com/shikijs/shiki/blob/master/docs/languages.md).
- add anchor links to headings
- cache results to increase performance

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-markdown.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-markdown)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Documentation

You can find installation instructions and detailed instructions on how to use this package at [the dedicated documentation site](https://docs.spatie.be/laravel-markdown/v1/introduction/).

## Related packages

If you only need the league/commonmark extension to highlight code, head over to [spatie/commonmark-shiki-highlighter](https://github.com/spatie/commonmark-shiki-highlighter).

In case you don't need the markdown support, but want to highlight code directly, take a look at [spatie/shiki-php](https://github.com/spatie/shiki-php).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## Alternatives

If you don't want to install and handle Shiki yourself, take a look at [Torchlight](https://torchlight.dev), which can highlight your code with minimal setup.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
