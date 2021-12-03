<?php

namespace Spatie\LaravelMarkdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Spatie\LaravelMarkdown\Renderers\AnchorHeadingRenderer;

class MarkdownRenderer
{
    public function __construct(
        protected array $commonmarkOptions = [],
        protected bool $highlightCode = true,
        protected string $highlightTheme = 'github-light',
        protected string | bool | null $cacheStoreName = null,
        protected bool $renderAnchors = true,
        protected array $extensions = [],
        protected array $blockRenderers = [],
        protected array $inlineRenderers = [],
    ) {
    }

    public function commonmarkOptions(array $options): self
    {
        $this->commonmarkOptions = $options;

        return $this;
    }

    public function highlightCode(bool $highlightCode = true): self
    {
        $this->highlightCode = $highlightCode;

        return $this;
    }

    public function disableHighlighting(): self
    {
        $this->highlightCode = false;

        return $this;
    }

    public function highlightTheme(string $highlightTheme): self
    {
        $this->highlightTheme = $highlightTheme;

        return $this;
    }

    public function cacheStoreName(string | bool | null $cacheStoreName): self
    {
        $this->cacheStoreName = $cacheStoreName;

        return $this;
    }

    public function renderAnchors(bool $renderAnchors): self
    {
        $this->renderAnchors = $renderAnchors;

        return $this;
    }

    public function disableAnchors(): self
    {
        $this->renderAnchors = false;

        return $this;
    }

    public function addExtension(ExtensionInterface $extension): self
    {
        $this->extensions[] = $extension;

        return $this;
    }

    public function addBlockRenderer(string $blockClass, NodeRendererInterface $blockRenderer): self
    {
        $this->blockRenderers[] = ['class' => $blockClass, 'renderer' => $blockRenderer];

        return $this;
    }

    public function addInlineRenderer(string $inlineClass, NodeRendererInterface $inlineRenderer): self
    {
        $this->inlineRenderers[] = ['class' => $inlineClass, 'renderer' => $inlineRenderer];

        return $this;
    }

    public function toHtml(string $markdown): string
    {
        if ($this->cacheStoreName === false) {
            return $this->convertMarkdownToHtml($markdown);
        }

        $cacheKey = $this->getCacheKey($markdown);

        return cache()
            ->store($this->cacheStoreName)
            ->rememberForever($cacheKey, function () use ($markdown) {
                return $this->convertMarkdownToHtml($markdown);
            });
    }

    protected function getCacheKey(string $markdown): string
    {
        $options = json_encode([
            'theme' => $this->highlightTheme,
            'render_anchors' => $this->renderAnchors,
            'commonmark_options' => $this->commonmarkOptions,
        ]);

        return md5("markdown{$markdown}{$options}");
    }

    protected function convertMarkdownToHtml(string $markdown): string
    {
        return $this->getMarkdownConverter()->convertToHtml($markdown);
    }

    protected function configureCommonMarkEnvironment(EnvironmentBuilderInterface $environment): void
    {
        $environment->addExtension(new CommonMarkCoreExtension());
        if ($this->highlightCode) {
            $environment->addExtension(new HighlightCodeExtension($this->highlightTheme));
        }

        if ($this->renderAnchors) {
            $environment->addRenderer(Heading::class, new AnchorHeadingRenderer());
        }

        foreach ($this->extensions as $extension) {
            if (is_string($extension) && class_exists($extension)) {
                $extension = new $extension();
            }
            $environment->addExtension($extension);
        }

        foreach ($this->blockRenderers as $blockRenderer) {
            $environment->addRenderer($blockRenderer['class'], $blockRenderer['renderer'], $blockRenderer['priority'] ?? 0);
        }

        foreach ($this->inlineRenderers as $inlineRenderer) {
            $environment->addRenderer($inlineRenderer['class'], $inlineRenderer['renderer'], $blockRenderer['priority'] ?? 0);
        }
    }

    private function getMarkdownConverter(): MarkdownConverter
    {
        $environment = new Environment($this->commonmarkOptions);
        $this->configureCommonMarkEnvironment($environment);

        return new MarkdownConverter(
            environment: $environment
        );
    }

    public function convertToHtml(string $markdown): RenderedContentInterface
    {
        return $this->getMarkdownConverter()->convertToHtml($markdown);
    }
}
