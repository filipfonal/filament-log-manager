<?php

namespace FilipFonal\FilamentLogManager\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use FilipFonal\FilamentLogManager\LogViewer;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Logs extends Page
{
    protected static string $view = 'filament-log-manager::pages.logs';

    public ?string $logFile = null;

    protected function getActions(): array
    {
        return [
            Action::make('settings')
                ->disabled($this->logFile === null)
                ->label('Download')
                ->action('openSettingsModal'),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'logs' => $this->getLogs(),
        ];
    }

    private function getLogs(): Collection
    {
        if (!$this->logFile) {
            return collect([]);
        }

        LogViewer::setFile($this->logFile);

        $logs = LogViewer::all();

        return collect($logs);
    }

    public function openSettingsModal(): void
    {
        dd('open-settings-modal');
    }

    protected function getForms(): array
    {
        return [
            'search' => $this->makeForm()
                ->schema($this->getFormSchema())
                ->model($this->getFormModel())
                ->statePath($this->getFormStatePath()),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('logFile')
                ->searchable()
                ->reactive()
                ->disableLabel()
                ->placeholder(__('log::filament-laravel-log.forms.search.placeholder'))
                ->options(fn () => $this->getFileNames($this->getFinder())->take(5))
                ->getSearchResultsUsing(fn (string $query) => $this->getFileNames($this->getFinder()->name("*{$query}*"))),
        ];
    }

    protected function getFileNames($files): Collection
    {
        return collect($files)->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getRealPath() => $file->getRealPath()];
        });
    }

    protected function getFinder(): Finder
    {
        return Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreUnreadableDirs()
            ->files()
            ->in(config('filament-laravel-log.logsDir'))
            ->notName(config('filament-laravel-log.exclude'));
    }

    protected static function getNavigationIcon(): string
    {
        return 'heroicon-o-server';
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament-log-manager::translations.navigation_label');
    }

    protected function getTitle(): string
    {
        return __('filament-log-manager::translations.title');
    }

    protected static function getNavigationGroup(): string
    {
        return __('filament-log-manager::translations.group');
    }
}
