<?php

namespace FilipFonal\FilamentLogManager;

use Filament\PluginServiceProvider;
use FilipFonal\FilamentLogManager\Commands\FilamentLogManagerCommand;
use FilipFonal\FilamentLogManager\Pages\Logs;
use Spatie\LaravelPackageTools\Package;

class FilamentLogManagerServiceProvider extends PluginServiceProvider
{
    protected array $styles = [
        'filament-log-manager-styles' => __DIR__ . '/../resources/css/styles.css',
    ];

    protected array $pages = [
        Logs::class,
    ];
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-log-manager')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_filament-log-manager_table')
            ->hasCommand(FilamentLogManagerCommand::class);
    }
}
