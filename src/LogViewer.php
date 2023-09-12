<?php

namespace FilipFonal\FilamentLogManager;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class LogViewer
{
    private const LOG_LEVEL_CLASSES = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'processed' => 'info',
        'warning' => 'warning',
        'error' => 'danger',
        'critical' => 'danger',
        'alert' => 'danger',
        'emergency' => 'danger',
    ];

    private const LOG_LEVELS = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
        'processed',
    ];

    private const MAX_FILE_SIZE = 52428800;

    /**
     * @throws FileNotFoundException
     * @throws Exception
     */
    public static function getAllForFile(string $file): array
    {
        $file = self::pathToLogFile($file);

        if (!File::exists($file)) {
            throw new Exception(__('filament-log-manager::translations.no_such_file'));
        }

        if (File::size($file) > self::MAX_FILE_SIZE) {
            throw new Exception(__('filament-log-manager::translations.file_too_large'));
        }

        $logs = [];
        $file = File::get($file);
        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/';

        preg_match_all($pattern, $file, $headings);

        if (!is_array($headings)) {
            return $logs;
        }

        $stackTrace = preg_split($pattern, $file);

        if ($stackTrace[0] < 1) {
            array_shift($stackTrace);
        }

        foreach ($headings as $heading) {
            for ($i = 0, $j = count($heading); $i < $j; $i++) {
                foreach (self::LOG_LEVELS as $level) {
                    if (strpos(strtolower($heading[$i]), '.'.$level) || strpos(strtolower($heading[$i]), $level.':')) {
                        $pattern = '/^\[(?P<date>(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}))\](?:.*?(?P<context>(\w+))\.|.*?)'.$level.': (?P<text>.*?)(?P<in_file> in .*?:[0-9]+)?$/i';
                        preg_match($pattern, $heading[$i], $current);
                        if (!isset($current['text'])) {
                            continue;
                        }

                        $logs[] = [
                            'context' => $current['context'],
                            'level' => $level,
                            'level_class' => self::LOG_LEVEL_CLASSES[$level],
                            'date' => $current['date'],
                            'text' => $current['text'],
                            'in_file' => $current['in_file'] ?? null,
                            'stack' => preg_replace("/^\n*/", '', $stackTrace[$i]),
                        ];
                    }
                }
            }
        }

        return array_reverse($logs);
    }

    /**
     * @throws Exception
     */
    public static function pathToLogFile(string $file): string
    {
        $logsPath = storage_path('logs');

        if (File::exists($file)) {
            return $file;
        }

        $file = $logsPath . '/' . $file;

        if (dirname($file) !== $logsPath) {
            throw new Exception(__('filament-log-manager::translations.no_such_file'));
        }

        return $file;
    }
}
