<?php

namespace Spatie\LaravelMarkdown;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Environment;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
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
        protected array $inlineRenders = [],
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

    public function addBlockRenderer(string $blockClass, BlockRendererInterface $blockRenderer): self
    {
        $this->blockRenderers[] = ['class' => $blockClass, 'renderer' => $blockRenderer];

        return $this;
    }

    public function addInlineRenderer(string $inlineClass, InlineRendererInterface $inlineRenderer): self
    {
        $this->inlineRenders[] = ['class' => $inlineClass, 'renderer' => $inlineRenderer];

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
        $environment = Environment::createCommonMarkEnvironment();
        $environment->mergeConfig($this->commonmarkOptions);

        $this->configureCommonMarkEnvironment($environment);

        $commonMarkConverter = new CommonMarkConverter(
            environment: $environment
        );

        return $commonMarkConverter->convertToHtml($markdown);
    }

    protected function configureCommonMarkEnvironment(ConfigurableEnvironmentInterface $environment): void
    {
        if ($this->highlightCode) {
            $environment->addExtension(new HighlightCodeExtension($this->highlightTheme));
        }

        if ($this->renderAnchors) {
            $environment->addBlockRenderer(Heading::class, new AnchorHeadingRenderer());
        }

        foreach ($this->extensions as $extension) {
            $environment->addExtension($extension);
        }

        foreach ($this->blockRenderers as $blockRenderer) {
            $environment->addBlockRenderer($blockRenderer['class'], $blockRenderer['renderer']);
        }

        foreach ($this->inlineRenders as $inlineRenderer) {
            $environment->addInlineRenderer($inlineRenderer['class'], $inlineRenderer['renderer']);
        }

        $environment->mergeConfig($this->commonmarkOptions);
    }
}
