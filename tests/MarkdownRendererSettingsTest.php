<?php

use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\MarkdownConverter;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\LaravelMarkdown\Tests\Stubs\InlineTextDividerRenderer;
use Spatie\LaravelMarkdown\Tests\Stubs\TextDividerRenderer;

function markdownConverter(?MarkdownRenderer $markdownRenderer = null): MarkdownConverter
{
    if ($markdownRenderer === null) {
        $markdownRenderer = app(MarkdownRenderer::class);
    }

    $reflectionClass = new ReflectionClass(MarkdownRenderer::class);
    $reflectionMethod = $reflectionClass->getMethod('getMarkdownConverter');
    $reflectionMethod->setAccessible(true);

    return $reflectionMethod->invoke($markdownRenderer);
}

function getProtectedPropertyValue(object $object, string $propertyName): mixed
{
    $reflectedClass = new ReflectionClass($object);
    $reflectedProperty = $reflectedClass->getProperty($propertyName);
    $reflectedProperty->setAccessible(true);

    return $reflectedProperty->getValue($object);
}

it('can modify highlight code option', function () {
    $markdownRenderer = markdownRenderer();
    $initialValue = getProtectedPropertyValue($markdownRenderer, 'highlightCode');
    expect($initialValue)->toBeTrue();

    $markdownRenderer->highlightCode(false);

    expect(getProtectedPropertyValue($markdownRenderer, 'highlightCode'))->not->toEqual($initialValue);
    expect(getProtectedPropertyValue($markdownRenderer, 'highlightCode'))->toBeFalse();
});

it('can modify render anchors option', function () {
    $markdownRenderer = markdownRenderer();
    $initialValue = getProtectedPropertyValue($markdownRenderer, 'renderAnchors');
    expect($initialValue)->toBeTrue();

    $markdownRenderer->renderAnchors(false);

    expect(getProtectedPropertyValue($markdownRenderer, 'renderAnchors'))->not->toEqual($initialValue);
    expect(getProtectedPropertyValue($markdownRenderer, 'renderAnchors'))->toBeFalse();
});

it('can register block renderers', function () {
    config()->set('markdown.block_renderers', [
        ['class' => ThematicBreak::class, 'renderer' => new TextDividerRenderer(), 'priority' => 25],
    ]);

    $renderers = markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
    $priorityArray = getProtectedPropertyValue($renderers, 'list');

    expect(array_keys($priorityArray)[0])->toEqual(25);
    expect($priorityArray)->toHaveKey(25);
    expect($priorityArray[25])->toHaveKey(0);
    expect($priorityArray[25][0])->toBeInstanceOf(TextDividerRenderer::class);
});

it('can register inline renderers', function () {
    config()->set('markdown.inline_renderers', [
        ['class' => ThematicBreak::class, 'renderer' => new InlineTextDividerRenderer(), 'priority' => 42],
    ]);

    $renderers = markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
    $priorityArray = getProtectedPropertyValue($renderers, 'list');

    expect(array_keys($priorityArray)[0])->toEqual(42);
    expect($priorityArray)->toHaveKey(42);
    expect($priorityArray[42])->toHaveKey(0);
    expect($priorityArray[42][0])->toBeInstanceOf(InlineTextDividerRenderer::class);
});

it('can dynamically register renderers', function () {
    $markdownRenderer = markdownRenderer();
    $markdownRenderer = $markdownRenderer->addBlockRenderer(ThematicBreak::class, new TextDividerRenderer(), 42);
    $markdownRenderer = $markdownRenderer->addInlineRenderer(ThematicBreak::class, new InlineTextDividerRenderer(), 25);

    $markdownConverter = markdownConverter($markdownRenderer);
    $renderersList = $markdownConverter->getEnvironment()->getRenderersForClass(ThematicBreak::class);
    $priorityArray = getProtectedPropertyValue($renderersList, 'list');

    expect(array_keys($priorityArray)[0])->toEqual(42);
    expect($priorityArray)->toHaveKey(42);
    expect($priorityArray[42][0])->toBeInstanceOf(TextDividerRenderer::class);
    expect(array_keys($priorityArray)[1])->toEqual(25);
    expect($priorityArray)->toHaveKey(25);
    expect($priorityArray[25][0])->toBeInstanceOf(InlineTextDividerRenderer::class);
});
