<?php

namespace FilipFonal\FilamentLogManager;

use Filament\Support\Assets\Css;
use Spatie\LaravelPackageTools\Package;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use FilipFonal\FilamentLogManager\Commands\FilamentLogManagerCommand;

class FilamentLogManagerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-log-manager';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasCommand(FilamentLogManagerCommand::class);
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        FilamentAsset::register([
            Css::make('filament-log-manager', __DIR__.'/../resources/css/styles.css'),
        ], 'filipfonal/filament-log-manager');
    }
}
