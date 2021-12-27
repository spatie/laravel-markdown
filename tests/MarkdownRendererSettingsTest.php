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
        // get and verify initial value
        $initialValue = $this->getProtectedPropertyValue($markdownRenderer, 'highlightCode');
        $this->assertTrue($initialValue);
        // Call a method that modifies the value...
        $markdownRenderer->highlightCode(false);
        // Verify the value changed from previous value and is now false
        $this->assertNotEquals($initialValue, $this->getProtectedPropertyValue($markdownRenderer, 'highlightCode'));
        $this->assertFalse($this->getProtectedPropertyValue($markdownRenderer, 'highlightCode'));
    }

    /** @test */
    public function it_can_modify_render_anchors_option()
    {
        $markdownRenderer = $this->markdownRenderer();
        // get and verify initial value
        $initialValue = $this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors');
        $this->assertTrue($initialValue);
        // Call a method that modifies the value...
        $markdownRenderer->renderAnchors(false);
        // Verify the value changed from previous value and is now false
        $this->assertNotEquals($initialValue, $this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors'));
        $this->assertFalse($this->getProtectedPropertyValue($markdownRenderer, 'renderAnchors'));
    }

    /** @test */
    public function it_can_register_block_renderers()
    {
        config()->set('markdown.block_renderers', [
            ['class' => ThematicBreak::class, 'renderer' => new TextDividerRenderer(), 'priority' => 25],
        ]);

        // Using the configured Environment get all the Renderers for the ThematicBreak class
        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        // Get the raw list from the priority list...this ensures we preserve the ordered IDs
        $priorityArray = $this->getProtectedPropertyValue($renderers, 'list');
        // Verify the items registered via 'markdown.block_renderers' were registered with the proper priority
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

        // Using the configured Environment get all the Renderers for the ThematicBreak class
        $renderers = $this->markdownConverter()->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        // Get the raw list from the priority list...this ensures we preserve the ordered IDs
        $priorityArray = $this->getProtectedPropertyValue($renderers, 'list');
        // Verify the items registered via 'markdown.inline_renderers' were registered with the proper priority
        $this->assertEquals(42, array_keys($priorityArray)[0]);
        $this->assertArrayHasKey(42, $priorityArray);
        $this->assertArrayHasKey(0, $priorityArray[42]);
        $this->assertInstanceOf(InlineTextDividerRenderer::class, $priorityArray[42][0]);
    }

    /** @test */
    public function it_can_dynamically_register_renderers()
    {
        // Prepare a version of markdown renderer to add block/inline renderer via method..
        $markdownRenderer = $this->markdownRenderer();
        $markdownRenderer = $markdownRenderer->addBlockRenderer(ThematicBreak::class, new TextDividerRenderer(), 42);
        $markdownRenderer = $markdownRenderer->addInlineRenderer(ThematicBreak::class, new InlineTextDividerRenderer(), 25);
        // Get the normally protected markdown converter and renderers list
        $markdownConverter = $this->markdownConverter($markdownRenderer);
        $renderersList = $markdownConverter->getEnvironment()->getRenderersForClass(ThematicBreak::class);
        // Get the raw list from the priority list...this ensures we preserve the ordered IDs
        $priorityArray = $this->getProtectedPropertyValue($renderersList, 'list');
        // Verify the items registered via 'markdown.inline_renderers' were registered with the proper priority
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

    protected function getProtectedPropertyValue(object $object, string $propertyName)
    {
        $reflectedClass = new ReflectionClass($object);
        $reflectedProperty = $reflectedClass->getProperty($propertyName);
        $reflectedProperty->setAccessible(true);
        return $reflectedProperty->getValue($object);
    }
}
