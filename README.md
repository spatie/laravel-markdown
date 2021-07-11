# A fully featured Blade component to render markdown and highlight code snippets

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-markdown-blade-component.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown-blade-component)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown-blade-component/run-tests?label=tests)](https://github.com/spatie/laravel-markdown-blade-component/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown-blade-component/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-markdown-blade-component/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-markdown-blade-component.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown-blade-component)

This package contains a Blade component that can render markdown to HTML. 

This chunk of markdown...

```blade
<x-markdown>
# This is a heading

Here is a [link to our website](https://spatie.be)

Some code

(`)(`)(`)php
echo 'hello world';
(`)(`)(`)
</x-markdown>
```

... will be converted to this chunk of HTML:

```html
TODO: add HTML
```

Out of the `x-markdown` component can:

- highlight code blocks correctly (via [Shiki PHP](https://github.com/spatie/shiki-php))
- add anchor links to headings
- cache results to increase performance



## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-markdown-blade-component.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-markdown-blade-component)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-markdown-blade-component
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Spatie\MarkdownBladeComponent\LaravelMarkdownBladeComponentServiceProvider" --tag="laravel-markdown-blade-component-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\MarkdownBladeComponent\LaravelMarkdownBladeComponentServiceProvider" --tag="laravel-markdown-blade-component-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-markdown-blade-component = new Spatie\MarkdownBladeComponent();
echo $laravel-markdown-blade-component->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
