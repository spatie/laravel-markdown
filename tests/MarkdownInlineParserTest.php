<?php

use Spatie\LaravelMarkdown\Tests\Stubs\CustomInlineParser;

it('can use custom inline parser', function () {
    config()->set('markdown.inline_parsers', [
        ['parser' => new CustomInlineParser(), 'priority' => 0],
    ]);

    $markdown = <<<MD
        I am a text with a very randomly placed @ symbol in the middle.
       MD;

    $html = markdownRenderer()
        ->disableAnchors()
        ->toHtml($markdown);

    expect($html)->toEqual('<p>I am a text with a very randomly placed THIS-REPLACED-THE-SYMBOL symbol in the middle.</p>' . PHP_EOL);
});

it('can use custom inline parser class', function () {
    config()->set('markdown.inline_parsers', [
        ['parser' => CustomInlineParser::class, 'priority' => 0],
    ]);

    $markdown = <<<MD
        I am a text with a very randomly placed @ symbol in the middle.
       MD;

    $html = markdownRenderer()
        ->disableAnchors()
        ->toHtml($markdown);

    expect($html)->toEqual('<p>I am a text with a very randomly placed THIS-REPLACED-THE-SYMBOL symbol in the middle.</p>' . PHP_EOL);
});
