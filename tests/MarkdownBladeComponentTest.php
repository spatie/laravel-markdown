<?php

namespace Spatie\LaravelMarkdown\Tests;

use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

it('the component can render markdown', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown>
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the component can use extensions', function () {
    config()->set('markdown.extensions', [
        new GithubFlavoredMarkdownExtension(),
    ]);

    $markdown = <<<BLADE
        <x-markdown>
        ~~Foo~~
        </x-markdown>
       BLADE;

    $renderedView = (string)$this->blade($markdown);

    expect($renderedView)->toMatchSnapshot();
});

it('the component can use a custom theme', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown theme="github-dark">
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the default theme can be set in the config file', function () {
    config()->set('markdown.code_highlighting.theme', 'github-dark');

    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown>
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the component can disable highlighting code', function () {
    config()->set('markdown.code_highlighting.enabled', false);

    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown :highlight-code="false">
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the highlighting can be disabled in the config file', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown :highlight-code="false">
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the component can render anchors as links', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown :anchors-links="true">
        # Title
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the component can disable rendering anchors', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        <x-markdown :anchors="false">
        # Title
        </x-markdown>
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the component can cache results', function () {
    $cacheKey = 'd1cd0dc15c848738f347cb539578252f';

    $markdown = <<<BLADE
        <x-markdown>
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
       BLADE;

    expect(cache()->get($cacheKey))->toBeNull();

    (string)$this->blade($markdown);

    expect(cache()->get($cacheKey))->not->toBeNull();
});

it('caching can be disabled', function () {
    config()->set('markdown.cache_store', false);

    $cacheKey = 'd1cd0dc15c848738f347cb539578252f';

    $markdown = <<<BLADE
        <x-markdown>
        ```php
        echo 'Hello world';
        ```
        </x-markdown>
       BLADE;

    expect(cache()->get($cacheKey))->toBeNull();

    (string)$this->blade($markdown);

    expect(cache()->get($cacheKey))->toBeNull();
});

it('attributes will be added to the wrapper div', function () {
    $markdown = <<<BLADE
        <x-markdown extraAttribute="extraValue">
        # Title
        </x-markdown>
       BLADE;

    $renderedView = (string)$this->blade($markdown);

    expect($renderedView)->toMatchSnapshot();
});
