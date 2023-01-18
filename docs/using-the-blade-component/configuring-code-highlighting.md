---
title: Configuring code highlighting
weight: 2
---

By default, [Shiki PHP](https://github.com/spatie/shiki-php) is used to highlight 100+ languages, including PHP, JS, Blade, [and many more](https://github.com/shikijs/shiki/blob/main/docs/languages.md).

In the `code_highlighting.theme` value of the `markdown` config file you can specify the default theme to be used. This value can be [one of the themes](https://github.com/shikijs/shiki/blob/main/docs/themes.md) that Shiki supports out of the box.

Shiki also [supports](https://github.com/shikijs/shiki/blob/main/docs/themes.md) any [VSCode themes](https://code.visualstudio.com/docs/getstarted/themes).

You can use a custom theme using the absolute path to a theme in as the value for `code_highlighting.theme`.

If you want to change the theme for a particular instance of `x-markdown`, pass a theme to the `theme` attribute.

````html
<x-markdown theme="github-dark">
```php
echo 'Hello world';
```
</x-markdown>
````

## Disabling code highlighting

Code highlighting can be disabled globally, by setting the `code_highlighting.enabled` key in the `markdown` config file to `false`.

If you don't want to use code highlighting for a particular instance of `x-markdown`, pass `false` to the `code-highlighting` attribute.

````html
<x-markdown :highlight-code="false">
```php
echo 'Hello world';
```
</x-markdown>
````
