<?php

namespace Spatie\LaravelMarkdown\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownBladeComponentTest extends TestCase
{
    use InteractsWithViews;
    use MatchesSnapshots;

    /** @test */
    public function the_component_can_render_markdown()
    {
        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown>
            # My title

            This is a [link to our website](https://spatie.be)

            ```php
            echo 'Hello world';
            ```
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_component_can_use_a_custom_theme()
    {
        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown theme="github-dark">
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_default_theme_can_be_set_in_the_config_file()
    {
        config()->set('markdown.code_highlighting.theme', 'github-dark');

        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown>
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_component_can_disable_highlighting_code()
    {
        config()->set('markdown.code_highlighting.enabled', false);

        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown :highlight-code="false">
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_highlighting_can_be_disabled_in_the_config_file()
    {
        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown :highlight-code="false">
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_component_can_disable_rendering_anchors()
    {
        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown :anchors="false">
            # Title
            </x-markdown>
            BLADE
        );

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_component_can_cache_results()
    {
        $cacheKey = 'd1cd0dc15c848738f347cb539578252f';

        $markdown = <<<BLADE
            <x-markdown>
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
           BLADE;

        $this->assertNull(cache()->get($cacheKey));

        (string)$this->blade($markdown);

        $this->assertNotNull(cache()->get($cacheKey));
    }

    /** @test */
    public function caching_can_be_disabled()
    {
        config()->set('markdown.cache_store', false);

        $cacheKey = 'd1cd0dc15c848738f347cb539578252f';

        $markdown = <<<BLADE
            <x-markdown>
            ```php
            echo 'Hello world';
            ```
            </x-markdown>
           BLADE;

        $this->assertNull(cache()->get($cacheKey));

        (string)$this->blade($markdown);

        $this->assertNull(cache()->get($cacheKey));
    }

    /** @test */
    public function attributes_will_be_added_to_the_wrapper_div()
    {
        $markdown = <<<BLADE
            <x-markdown extraAttribute="extraValue">
            # Title
            </x-markdown>
           BLADE;

        $renderedView = (string)$this->blade($markdown);

        $this->assertMatchesSnapshot($renderedView);
    }
}
