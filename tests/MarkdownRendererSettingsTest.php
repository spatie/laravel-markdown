<?php

namespace Spatie\LaravelMarkdown\Tests;

use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\MarkdownConverter;
use ReflectionClass;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\LaravelMarkdown\Tests\Stubs\InlineTextDividerRenderer;
use Spatie\LaravelMarkdown\Tests\Stubs\TextDividerRenderer;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownRendererSettingsTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_modify_highlight_code_option()
    {
        $markdownRenderer = $this->markdownRenderer();
        $initialValue = $this->getProtectedPropertyValue($markdownRenderer, 'highlightCode');
        $this->assertTrue($initialValue);
        
        $markdownRenderer->highlightCode(false);

        $this->assertNotEquals($initialValue, $this->getProtectedPropertyValue($markdownRenderer, 'highlightCode'));
        $this->assertFalse($this->getProtectedPropertyValue($markdownRenderer, 'highlightCode'));
    }

    /** @test */
    public function it_can_modify_render_anchors_option()
    {
        $markdownRenderer = $this->markdownRenderer();
        $initialValue = $this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors');
        $this->assertTrue($initialValue);
        
        $markdownRenderer->renderAnchors(false);
        
        $this->assertNotEquals($initialValue, $this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors'));
        $this->assertFalse($this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors'));
    }

    /** @test */
    public function it_can_register_block_renderers()
    {
        config()->set('markdown.block_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new TextDividerRenderer(), 'priority' => 25],
        ]);

        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $priorityArray = $this->getProtectedPropertyValue($renderers, 'list');

        $this->assertEquals(25, array_keys($priorityArray)[0]);
        $this->assertArrayHasKey(25, $priorityArray);
        $this->assertArrayHasKey(0, $priorityArray[25]);
        $this->assertInstanceOf(TextDividerRenderer::class, $priorityArray[25][0]);
    }

    /** @test */
    public function it_can_register_inline_renderers()
    {
        config()->set('markdown.inline_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new InlineTextDividerRenderer(), 'priority' => 42],
        ]);

        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $priorityArray = $this->getProtectedPropertyValue($renderers, 'list');

        $this->assertEquals(42, array_keys($priorityArray)[0]);
        $this->assertArrayHasKey(42, $priorityArray);
        $this->assertArrayHasKey(0, $priorityArray[42]);
        $this->assertInstanceOf(InlineTextDividerRenderer::class, $priorityArray[42][0]);
    }

    /** @test */
    public function it_can_dynamically_register_renderers()
    {
        $markdownRenderer = $this->markdownRenderer();
        $markdownRenderer = $markdownRenderer->addBlockRenderer(ThematicBreak::class, new TextDividerRenderer(), 42);
        $markdownRenderer = $markdownRenderer->addInlineRenderer(ThematicBreak::class, new InlineTextDividerRenderer(), 25);

        $markdownConverter = $this->markdownConverter($markdownRenderer);
        $renderersList = $markdownConverter->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $priorityArray = $this->getProtectedPropertyValue($renderersList, 'list');

        $this->assertEquals(42, array_keys($priorityArray)[0]);
        $this->assertArrayHasKey(42, $priorityArray);
        $this->assertInstanceOf(TextDividerRenderer::class, $priorityArray[42][0]);
        $this->assertEquals(25, array_keys($priorityArray)[1]);
        $this->assertArrayHasKey(25, $priorityArray);
        $this->assertInstanceOf(InlineTextDividerRenderer::class, $priorityArray[25][0]);
    }

    protected function markdownRenderer(): MarkdownRenderer
    {
        return app(MarkdownRenderer::class);
    }

    protected function markdownConverter(?MarkdownRenderer $markdownRenderer = null): MarkdownConverter
    {
        if ($markdownRenderer === null) {
            $markdownRenderer = app(MarkdownRenderer::class);
        }
        
        $reflectionClass = new ReflectionClass(MarkdownRenderer::class);
        $reflectionMethod = $reflectionClass->getMethod('getMarkdownConverter');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invoke($markdownRenderer);
    }

    protected function getProtectedPropertyValue(object $object, string $propertyName): mixed
    {
        $reflectedClass = new ReflectionClass($object);
        $reflectedProperty = $reflectedClass->getProperty($propertyName);
        $reflectedProperty->setAccessible(true);
        
        return $reflectedProperty->getValue($object);
    }
}
