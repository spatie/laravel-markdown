---
title: Installation & setup
weight: 4
---

You can install the package via composer:

```bash
composer require spatie/laravel-markdown
```

To enable the code highlighting feature, you'll need to install the JavaScript package [`shiki`](https://github.com/shikijs/shiki) in your project. You can install it via npm...

```bash
npm install shiki
```

... or Yarn.

```bash
yarn add shiki
```

Make sure you have installed Node 10 or higher.

Optionally, You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\LaravelMarkdown\LaravelMarkdownBladeComponentServiceProvider" --tag="markdown-config"
```

This is the contents of the published config file:

```php
return [
    'code_highlighting' => [
        /*
         * To highlight code, we'll use Shiki under the hood. Make sure it's installed.
         *
         * More info: https://github.com/spatie/laravel-markdown#installation
         */
        'enabled' => true,

        /*
         * The name of or path to a Shiki theme
         *
         * More info: https://github.com/spatie/laravel-markdown#specifying-the-theme-used-for-code-highlighting
         */
        'theme' => 'github-light',
    ],

    /*
     * When enabled, anchor links will be added to all titles
     */
    'add_anchors_to_headings' => true,

    /*
     * These options will be passed to the league/commonmark package which is
     * used under the hood to render markdown.
     *
     * More info: https://github.com/spatie/laravel-markdown#passing-options-to-commonmark
     */
    'commonmark_options' => [],

    /*
     * Rendering markdown to HTML can be resource intensive. By default
     * we'll cache the results.
     *
     * You can specify the name of a cache store here. When set to `null`
     * the default cache store will be used. If you do not want to use
     * caching set this value to `false`.
     */
    'cache_store' => null,

    /*
     * This class will convert markdown to HTML
     *
     * You can change this to a class of your own to greatly
     * customize the rendering process
     *
     * More info: https://github.com/spatie/laravel-markdown#customizing-the-rendering-process
     */
    'renderer_class' => Spatie\LaravelMarkdown\MarkdownRenderer::class,

    /*
     * These extensions should be added to the markdown environment. An valid
     * extension implements League\CommonMark\Extension\ExtensionInterface
     *
     * More info: https://commonmark.thephpleague.com/1.6/extensions/overview/
     */
    'extensions' => [
        //
    ],

    /*
     * These renderers should be added to the markdown environment. An valid
     * renderer implements League\CommonMark\Block\Renderer\BlockRendererInterface;
     *
     * More info: https://commonmark.thephpleague.com/1.6/customization/block-rendering/
     */
    'block_renderers' => [
        // ['blockClass' => FencedCode::class, 'renderer' => new MyCustomCodeRenderer()]
    ],
];
```

