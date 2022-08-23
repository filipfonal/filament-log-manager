<?php

namespace FilipFonal\FilamentLogManager;

use Filament\PluginServiceProvider;
use FilipFonal\FilamentLogManager\Commands\FilamentLogManagerCommand;
use FilipFonal\FilamentLogManager\Pages\LogItem;
use FilipFonal\FilamentLogManager\Pages\Logs;
use Spatie\LaravelPackageTools\Package;

class FilamentLogManagerServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        Logs::class,
        LogItem::class,
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
