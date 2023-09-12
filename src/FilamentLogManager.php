<?php

namespace FilipFonal\FilamentLogManager;

use Filament\Contracts\Plugin;
use Filament\Panel;
use FilipFonal\FilamentLogManager\Pages\Logs;

class FilamentLogManager implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-log-manager';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                config('filament-log-manager.page_class') ?? Logs::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
