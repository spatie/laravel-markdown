<?php

namespace Spatie\LaravelMarkdownBladeComponent\Commands;

use Illuminate\Console\Command;

class LaravelMarkdownBladeComponentCommand extends Command
{
    public $signature = 'laravel-markdown-blade-component';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
