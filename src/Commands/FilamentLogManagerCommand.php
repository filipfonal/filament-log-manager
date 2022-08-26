<?php

namespace FilipFonal\FilamentLogManager\Commands;

use Illuminate\Console\Command;

class FilamentLogManagerCommand extends Command
{
    public $signature = 'filament-log-manager';

    public $description = 'Install log manager';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
