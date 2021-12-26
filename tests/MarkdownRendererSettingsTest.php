<?php

namespace Spatie\LaravelMarkdown\Tests;

use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownRendererSettingsTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_can_modify_highlight_code_option()
    {
        $markdownRenderer = $this->markdownRenderer();
        $reflectedClass = new \ReflectionClass($markdownRenderer);
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
        $reflectedClass = new \ReflectionClass($markdownRenderer);
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
        $refelctionClass = new \ReflectionClass($renderers);
        $reflectionProperty = $refelctionClass->getProperty('list');
        $this->assertEquals(25, array_keys($reflectionProperty->getValue($renderers))[0]);
        $this->assertInstanceOf(TextDividerRenderer::class, $reflectionProperty->getValue($renderers)[25][0]);
    }

    /** @test */
    public function it_can_register_inline_renderers()
    {
        config()->set('markdown.inline_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new TextDividerRenderer(), 'priority' => 42],
        ]);

        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        $refelctionClass = new \ReflectionClass($renderers);
        $reflectionProperty = $refelctionClass->getProperty('list');
        $this->assertEquals(42, array_keys($reflectionProperty->getValue($renderers))[0]);
        $this->assertInstanceOf(TextDividerRenderer::class, $reflectionProperty->getValue($renderers)[42][0]);
    }

    protected function markdownRenderer(): MarkdownRenderer
    {
        return app(MarkdownRenderer::class);
    }

    protected function markdownConverter(): MarkdownConverter
    {
        $reflectionClass = new \ReflectionClass(MarkdownRenderer::class);
        $reflectionMethod = $reflectionClass->getMethod('getMarkdownConverter');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invoke(app(MarkdownRenderer::class));
    }
}

class TextDividerRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        return new HtmlElement('pre', ['class' => 'divider'], '==============================');
    }
}
