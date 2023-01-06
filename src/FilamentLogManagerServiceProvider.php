<?php

namespace FilipFonal\FilamentLogManager;

use Filament\PluginServiceProvider;
use FilipFonal\FilamentLogManager\Commands\FilamentLogManagerCommand;
use FilipFonal\FilamentLogManager\Pages\Logs;
use Spatie\LaravelPackageTools\Package;

class FilamentLogManagerServiceProvider extends PluginServiceProvider
{
    protected array $styles = [
        'filament-log-manager-styles' => __DIR__.'/../resources/css/styles.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-log-manager')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasCommand(FilamentLogManagerCommand::class);
    }

    protected function getPages(): array
    {
        return [
            config('filament-log-manager.page_class') ?? Logs::class,
        ];
    }
}
