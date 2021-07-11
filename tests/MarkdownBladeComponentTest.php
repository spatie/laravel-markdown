<?php

namespace Spatie\MarkdownBladeComponent\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class MarkdownBladeComponentTest extends TestCase
{
    use InteractsWithViews;

    /** @test */
    public function it_can_render_markdown()
    {
        $renderedView = (string)$this->blade(
            <<<BLADE
            <x-markdown>
            # Title
            [My link](https://example.com)
            </x-markdown>
            BLADE
        );

        dd($renderedView);
    }
}
