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
        protected bool $renderAnchorsAsLinks = false,
        protected array $extensions = [],
        protected array $blockRenderers = [],
        protected array $inlineRenderers = [],
        protected array $inlineParsers = [],
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

    public function renderAnchorsAsLinks(bool $renderAnchorsAsLinks): self
    {
        $this->renderAnchorsAsLinks = $renderAnchorsAsLinks;

        return $this;
    }

    public function enableAnchorsAsLinks(): self
    {
        $this->renderAnchorsAsLinks = true;

        return $this;
    }

    public function addExtension(ExtensionInterface $extension): self
    {
        $this->extensions[] = $extension;

        return $this;
    }

    public function addBlockRenderer(string $blockClass, NodeRendererInterface $blockRenderer, ?int $priority = 0): self
    {
        $this->blockRenderers[] = ['class' => $blockClass, 'renderer' => $blockRenderer, 'priority' => $priority];

        return $this;
    }

    public function addInlineRenderer(string $inlineClass, NodeRendererInterface $inlineRenderer, ?int $priority = 0): self
    {
        $this->inlineRenderers[] = ['class' => $inlineClass, 'renderer' => $inlineRenderer, 'priority' => $priority];

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
        return $this->getMarkdownConverter()->convert($markdown);
    }

    protected function getClassInstance($class)
    {
        if (is_string($class) && class_exists($class)) {
            $class = new $class();
        }

        return $class;
    }

    protected function configureCommonMarkEnvironment(EnvironmentBuilderInterface $environment): void
    {
        $environment->addExtension(new CommonMarkCoreExtension());
        if ($this->highlightCode) {
            $environment->addExtension(new HighlightCodeExtension($this->highlightTheme));
        }

        if ($this->renderAnchors) {
            $environment->addRenderer(Heading::class, new AnchorHeadingRenderer($this->renderAnchorsAsLinks));
        }

        foreach ($this->extensions as $extension) {
            $environment->addExtension($this->getClassInstance($extension));
        }

        foreach ($this->blockRenderers as $blockRenderer) {
            $environment->addRenderer($blockRenderer['class'], $this->getClassInstance($blockRenderer['renderer']), $blockRenderer['priority'] ?? 0);
        }

        foreach ($this->inlineRenderers as $inlineRenderer) {
            $environment->addRenderer($inlineRenderer['class'], $this->getClassInstance($inlineRenderer['renderer']), $inlineRenderer['priority'] ?? 0);
        }

        foreach ($this->inlineParsers as $inlineParser) {
            $environment->addInlineParser($this->getClassInstance($inlineParser['parser']), $inlineParser['priority'] ?? 0);
        }
    }

    private function getMarkdownConverter(): MarkdownConverter
    {
        $commonmarkOptions = $this->commonmarkOptions;

        if (isset($commonmarkOptions['embed'])) {
            $commonmarkOptions['embed']['adapter'] = $this->getClassInstance($commonmarkOptions['embed']['adapter']);
        }

        foreach ($commonmarkOptions['embeds'] ?? [] as $i => $embed) {
            $commonmarkOptions['embeds'][$i] = $this->getClassInstance($embed);
        }

        $environment = new Environment($commonmarkOptions);
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
