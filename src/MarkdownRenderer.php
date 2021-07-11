<?php

namespace Spatie\MarkdownBladeComponent;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Environment;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Spatie\MarkdownBladeComponent\Renderers\HeadingRenderer;

class MarkdownRenderer
{
    public function __construct(
        protected bool $highlightCode = true,
        protected ?string $highlightTheme = null,
        protected array $options = []
    ) {
        $this->highlightTheme ??= $this->options['default_theme'] ?? 'github-light';
    }

    public function convertToHtml(string $markdown): string
    {
        $cacheKey = $this->getCacheKey($markdown);

        return cache()
            ->store($this->options['cache_store'])
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
            ->addRenderers($environment)
            ->addExtensions($environment);

        $commonMarkConverter = new CommonMarkConverter(environment: $environment);

        return $commonMarkConverter->convertToHtml($markdown);
    }

    protected function addRenderers(ConfigurableEnvironmentInterface $environment): self
    {
        $environment->addBlockRenderer(Heading::class, new HeadingRenderer());

        return $this;
    }

    protected function addExtensions(ConfigurableEnvironmentInterface $environment): self
    {
        if ($this->highlightCode) {
            $environment->addExtension(new HighlightCodeExtension($this->highlightTheme));
        }

        return $this;
    }
}
