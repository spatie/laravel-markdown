**PACKAGE IN DEVELOPMENT, DO NOT USE YET**

# A fully featured Blade component to render markdown and highlight code snippets

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-markdown-blade-component.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown-blade-component)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown-blade-component/run-tests?label=tests)](https://github.com/spatie/laravel-markdown-blade-component/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-markdown-blade-component/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-markdown-blade-component/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-markdown-blade-component.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-markdown-blade-component)

This package contains a Blade component that can render markdown to HTML. 

This chunk of markdown...

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

Out of the box, the `x-markdown` component can:

- highlight code blocks correctly (via [Shiki PHP](https://github.com/spatie/shiki-php)) for 100+ languages, including PHP, JS, Blade, [and many more](https://github.com/shikijs/shiki/blob/master/docs/languages.md).
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

To enable the code highlighting feature, you'll need to install the JavaScript package [`shiki`](https://github.com/shikijs/shiki) in your project. You can install it via npm...

```bash
npm install shiki
```

... or Yarn.

```bash
yarn add shiki
```

Optionally, You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\MarkdownBladeComponent\LaravelMarkdownBladeComponentServiceProvider" --tag="markdown-blade-component-config"
```

This is the contents of the published config file:

```php
return [
    'code_highlighting' => [
        /*
         * To highlight code, we'll use Shiki under the hood. Make sure it's installed.
         *
         * More info: TODO: add link
         */
        'enabled' => true,

        /*
         * The name of or path to a Shiki theme
         *
         * More info: TODO: add link
         */
        'theme' => 'github-light',
    ],

    /*
     * When enabled, the markdown component will automatically add anchor
     * links to all titles
     */
    'add_anchors_to_headings' => true,
    
    /*
     * Rendering markdown to HTML can be resource intensive. By default
     * the markdown component caches its results.
     *
     * You can specify the name of a cache store here. When set to `null`
     * the default cache store will be used. If you do not want to use
     * caching set this value to `false`.
     */
    'cache_store' => null,

    /*
     * This class will convert the markdown to HTML.
     */
    'renderer_class' => Spatie\MarkdownBladeComponent\MarkdownRenderer::class,
];
```

## Usage

Use the `x-markdown` Blade component to render markdown to HTML.

This chunk of markdown...

```blade
<x-markdown>
# My title

This is a [link to our website](https://spatie.be)

```php
echo 'Hello world';
    ```
</x-markdown>
```

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

### Specifying the theme used for code highlighting

In the `code_highlighting.theme` value op the `markdown-blade-component` config file you can specify the default theme to be used. This value can be [one of the themes]((https://github.com/shikijs/shiki/blob/master/docs/themes.md)) that Shiki supports out of the box.

Shiki also [supports](https://github.com/shikijs/shiki/blob/master/docs/themes.md) any [VSCode themes](https://code.visualstudio.com/docs/getstarted/themes).

You can use a custom theme using the absolute path to a theme in as the value for `code_highlighting.theme`.

If you want to change the theme for a particular instance of `x-markdown`, pass a theme to the `theme` attribute.

````html
 <x-markdown theme="github-dark">
```php
echo 'Hello world';
```
</x-markdown>
````

### Disabling code highlighting

Code highlighting can be disabled globally, by setting the `code_highlighting.enabled` key in the `markdown-blade-component`  config file to `false`.

If you don't want to use code highlighting for a particular instance of `x-markdown`, pass `false` to the `code-highlighting` attribute.

````html
 <x-markdown :highlight-code="false">
```php
echo 'Hello world';
```
</x-markdown>
````

### Rendering anchors

By default, the component will add anchors to all headings in the rendered HTML. To disable this behaviour, you can set the `add_anchors_to_headings` config value in the the `markdown-blade-component`  config file to `false`.

If you don't want to render anchors for a particular instance of `x-markdown`, pass `false` to the `anchors` attribute.

```html
 <x-markdown :anchros="false">
# My title
</x-markdown>
```

### Adding custom attributes

You can add custom attributes by passing them to `x-markdown`. They will be rendered on the topmost wrapping div.

Here is an example where we add an `extra` attribute.

````html
<x-markdown extraAttribute="myValue">
# Title
</x-markdown>
````

This will be rendered as:

```html
<div extra="extraValue">
    <h1 id="title">Title</h1>
</div>
```

### Caching results

Code highlighting is a resource intensive process. That's why the component ships with caching out of the box. By default, the component uses the default cache store. 

To configure the store to use, or to disable caching, change the value of the `cache_store` param in the `markdown-blade-component` config file.

### Customizing the rendering process




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

## Alternatives

If you don't want to install and handle Shiki yourself, take a look at [Torchlight](https://torchlight.dev), which can highlight your code with minimal setup.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
