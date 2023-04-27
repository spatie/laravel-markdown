<?php

namespace Spatie\LaravelMarkdown\Tests;

use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

it('the directive can render markdown', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        @markdown
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        @endmarkdown
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the directive can render markdown with argument', function () {
    $renderedView = (string)$this->blade(
        <<<BLADE
        @markdown('This is a [link to our website](https://spatie.be)')
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the directive can use extensions', function () {
    config()->set('markdown.extensions', [
        new GithubFlavoredMarkdownExtension(),
    ]);

    $markdown = <<<BLADE
        @markdown
        ~~Foo~~
        @endmarkdown
       BLADE;

    $renderedView = (string)$this->blade($markdown);

    expect($renderedView)->toMatchSnapshot();
});

it('the default theme can be set in the config file', function () {
    config()->set('markdown.code_highlighting.theme', 'github-dark');

    $renderedView = (string)$this->blade(
        <<<BLADE
        @markdown
        ```php
        echo 'Hello world';
        ```
        @endmarkdown
        BLADE
    );

    expect($renderedView)->toMatchSnapshot();
});

it('the directive can cache results', function () {
    $cacheKey = 'a45df2668df6cd2fbb409dba10e2d3d6';

    $markdown = <<<BLADE
        @markdown
        ```php
        echo 'Hello world';
        ```
        @endmarkdown
       BLADE;

    expect(cache()->get($cacheKey))->toBeNull();

    (string)$this->blade($markdown);

    expect(cache()->get($cacheKey))->not->toBeNull();
});

it('caching can be disabled', function () {
    config()->set('markdown.cache_store', false);

    $cacheKey = 'a45df2668df6cd2fbb409dba10e2d3d6';

    $markdown = <<<BLADE
        @markdown
        ```php
        echo 'Hello world';
        ```
        @endmarkdown
       BLADE;

    expect(cache()->get($cacheKey))->toBeNull();

    (string)$this->blade($markdown);

    expect(cache()->get($cacheKey))->toBeNull();
});
