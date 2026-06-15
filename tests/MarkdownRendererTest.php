<?php

use League\CommonMark\Extension\Footnote\FootnoteExtension;
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

it('can render footnotes using the footnote extension', function () {
    config()->set('markdown.extensions', [
        new FootnoteExtension(),
    ]);

    $markdown = <<<MD
        Here is a footnote reference.[^1]

        [^1]: Here is the footnote.
        MD;

    $html = markdownRenderer()
        ->disableAnchors()
        ->toHtml($markdown);

    expect($html)
        ->toContain('class="footnote-ref"')
        ->toContain('id="fn:1"')
        ->toContain('Here is the footnote.');
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

it('can use an alternative highlighting theme', function () {
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

it(
    'can use two highlighting themes',
    function () {
        $markdown = <<<MD
        # My title

        This is a [link to our website](https://spatie.be)

        ```php
        echo 'Hello world';
        ```
        MD;

        $html = markdownRenderer()
            ->highlightTheme([
                'dark' => 'github-dark',
                'light' => 'github-light',
            ])
            ->toHtml($markdown);

        expect($html)->toMatchSnapshot();
    }
);

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
