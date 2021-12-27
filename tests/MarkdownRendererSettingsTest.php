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
        $reflectedClass = new ReflectionClass($markdownRenderer);
        $reflectedProperty = $reflectedClass->getProperty('highlightCode');
        $reflectedProperty->setAccessible(true);
        $previousValue = $reflectedProperty->getValue($markdownRenderer);
        $this->assertTrue($previousValue);
        $markdownRenderer->highlightCode(false);
        $this->assertNotEquals($previousValue, $reflectedProperty->getValue($markdownRenderer));
        $this->assertFalse(($previousValue = $reflectedProperty->getValue($markdownRenderer)));
    }

    /** @test */
    public function it_can_modify_render_anchors_option()
    {
        $markdownRenderer = $this->markdownRenderer();
        $reflectedClass = new ReflectionClass($markdownRenderer);
        $reflectedProperty = $reflectedClass->getProperty('renderAnchors');
        $reflectedProperty->setAccessible(true);
        $previousValue = $reflectedProperty->getValue($markdownRenderer);
        $this->assertTrue($previousValue);
        $markdownRenderer->renderAnchors(false);
        $this->assertNotEquals($previousValue, $reflectedProperty->getValue($markdownRenderer));
        $this->assertFalse(($previousValue = $reflectedProperty->getValue($markdownRenderer)));
    }

    /** @test */
    public function it_can_register_block_renderers()
    {
        config()->set('markdown.block_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new TextDividerRenderer(), 'priority' => 25],
        ]);

        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $refelctionClass = new ReflectionClass($renderers);
        $reflectionProperty = $refelctionClass->getProperty('list');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(25, array_keys($reflectionProperty->getValue($renderers))[0]);
        $this->assertInstanceOf(TextDividerRenderer::class, $reflectionProperty->getValue($renderers)[25][0]);
    }

    /** @test */
    public function it_can_register_inline_renderers()
    {
        config()->set('markdown.inline_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new InlineTextDividerRenderer(), 'priority' => 42],
        ]);

        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $refelctionClass = new ReflectionClass($renderers);
        $reflectionProperty = $refelctionClass->getProperty('list');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(42, array_keys($reflectionProperty->getValue($renderers))[0]);
        $this->assertInstanceOf(InlineTextDividerRenderer::class, $reflectionProperty->getValue($renderers)[42][0]);
    }

    /** @test */
    public function it_can_dynamically_register_renderers()
    {
        $markdownRenderer = $this->markdownRenderer();
        $markdownRenderer = $markdownRenderer->addBlockRenderer(ThematicBreak::class, new TextDividerRenderer(), 42);
        $markdownRenderer = $markdownRenderer->addInlineRenderer(ThematicBreak::class, new InlineTextDividerRenderer(), 25);

        $markdownConverter = $this->markdownConverter($markdownRenderer);
        $renderersList = $markdownConverter->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $refelctionClass = new ReflectionClass($renderersList);
        $reflectionProperty = $refelctionClass->getProperty('list');
        $reflectionProperty->setAccessible(true);
        $orderedList = $reflectionProperty->getValue($renderersList);
        $this->assertEquals(42, array_keys($orderedList)[0]);
        $this->assertEquals(25, array_keys($orderedList)[1]);
        $this->assertInstanceOf(TextDividerRenderer::class, $orderedList[42][0]);
        $this->assertInstanceOf(InlineTextDividerRenderer::class, $orderedList[25][0]);
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
}
