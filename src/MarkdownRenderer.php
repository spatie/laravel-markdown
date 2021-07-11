<?php

namespace Spatie\MarkdownBladeComponent;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Environment;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Spatie\MarkdownBladeComponent\Renderers\AnchorHeadingRenderer;

class MarkdownRenderer
{
    public function __construct(
        protected array $commonmarkOptions = [],
        protected bool $highlightCode = true,
        protected string $highlightTheme = 'github-light',
        protected string|bool|null $cacheStoreName = null,
        protected bool $renderAnchors = true,
    ) {
        $this->highlightTheme ??= $this->options['code_highlighting.theme'] ?? 'github-light';
    }

    public function convertToHtml(string $markdown): string
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
        $options = json_encode(['theme' => $this->highlightTheme]);

        return md5("markdown{$markdown}{$options}");
    }

    protected function convertMarkdownToHtml(string $markdown): string
    {
        $environment = Environment::createCommonMarkEnvironment();

        $this
            ->addExtensions($environment)
            ->addRenderers($environment);

        $commonMarkConverter = new CommonMarkConverter(

            environment: $environment
        );

        return $commonMarkConverter->convertToHtml($markdown);
    }

    protected function addExtensions(ConfigurableEnvironmentInterface $environment): self
    {
        if ($this->highlightCode) {
            $environment->addExtension(new HighlightCodeExtension($this->highlightTheme));
        }

        return $this;
    }

    protected function addRenderers(ConfigurableEnvironmentInterface $environment): self
    {
        if ($this->renderAnchors) {
            $environment->addBlockRenderer(Heading::class, new AnchorHeadingRenderer());
        }

        return $this;
    }
}
