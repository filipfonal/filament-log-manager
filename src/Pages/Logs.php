<?php

namespace FilipFonal\FilamentLogManager\Pages;

use Exception;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use FilipFonal\FilamentLogManager\LogViewer;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Logs extends Page
{
    protected static string $view = 'filament-log-manager::pages.logs';

    public ?string $logFile = null;

    public static function canAccess(): bool
    {
        $permission = config('filament-log-manager.permissions.view_logs');

        if ($permission && array_key_exists($permission, Gate::abilities())) {
            return Gate::allows($permission);
        }

        return true;
    }

    /**
     * @throws FileNotFoundException
     */
    public function getLogs(): Collection
    {
        if (!$this->logFile) {
            return collect([]);
        }

        $logs = LogViewer::getAllForFile($this->logFile);

        return collect($logs);
    }

    /**
     * @throws Exception
     */
    public function download(): BinaryFileResponse
    {
        if (!config('filament-log-manager.allow_download')) {
            abort(403);
        }

        return response()->download(LogViewer::pathToLogFile($this->logFile));
    }

    /**
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!config('filament-log-manager.allow_delete')) {
            abort(403);
        }

        if (File::delete(LogViewer::pathToLogFile($this->logFile))) {
            $this->logFile = null;

            return true;
        }

        abort(404, __('filament-log-manager::translations.no_such_file'));
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
                ->placeholder(__('filament-log-manager::translations.search_placeholder'))
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
            ->in(config('filament-log-manager.logs_directory'));
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-log-manager.navigation_icon');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-log-manager::translations.navigation_label');
    }

    public function getTitle(): string
    {
        return __('filament-log-manager::translations.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-log-manager.navigation_group') ? __('filament-log-manager::translations.navigation_group') : null;
    }
}
