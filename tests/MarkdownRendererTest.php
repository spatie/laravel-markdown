<?php

use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

it('can render markdown', function () {
    $markdown = <<<MD
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        MD;

    $html = markdownRenderer()->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});

it('can use extensions', function () {
    config()->set('markdown.extensions', [
        new GithubFlavoredMarkdownExtension(),
    ]);

    $markdown = <<<MD
        ~~Foo~~
       MD;

    $html = markdownRenderer()
       ->disableAnchors()
       ->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});

it('can disable highlighting', function () {
    $markdown = <<<MD
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        MD;

    $html = markdownRenderer()
        ->disableHighlighting()
        ->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});

it('can use an alternative highlighting them', function () {
    $markdown = <<<MD
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        MD;

    $html = markdownRenderer()
        ->highlightTheme('github-dark')
        ->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});

it('can disable rendering anchors', function () {
    $markdown = <<<MD
        # My title
        MD;

    $html = markdownRenderer()
        ->disableAnchors()
        ->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});

it('can enable rendering anchors as links', function () {
    $markdown = <<<MD
        # My title
        MD;

    $html = markdownRenderer()
        ->enableAnchorsAsLinks()
        ->toHtml($markdown);

    expect($html)->toMatchSnapshot();
});
