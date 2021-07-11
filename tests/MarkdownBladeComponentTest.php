<?php

namespace Spatie\MarkdownBladeComponent\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Spatie\Snapshots\MatchesSnapshots;

class MarkdownBladeComponentTest extends TestCase
{
    use InteractsWithViews;
    use MatchesSnapshots;

    /** @test */
    public function it_can_render_markdown()
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
}
