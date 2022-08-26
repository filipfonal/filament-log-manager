<?php

namespace FilipFonal\FilamentLogManager;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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

    const MAX_FILE_SIZE = 52428800;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function getAllForFile(string $file): array
    {
        /** @var Filesystem $filesystem */
        $filesystem = app(Filesystem::class);

        $file = $this->pathToLogFile($file);

        if (!$filesystem->exists($file)) {
            throw new Exception('No such log file');
        }

        if ($filesystem->size($file) > self::MAX_FILE_SIZE) {
            throw new Exception('File is too large');
        }

        $logs = [];
        $file = $filesystem->get($file);
        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/';

        preg_match_all($pattern, $file, $headings);

        if (!is_array($headings)) {
            return $logs;
        }

        $stackTrace = preg_split($pattern, $file);

        if ($stackTrace[0] < 1) {
            array_shift($stackTrace);
        }

        foreach ($headings as $h) {
            for ($i = 0, $j = count($h); $i < $j; $i++) {
                foreach (self::LOG_LEVELS as $level) {
                    if (strpos(strtolower($h[$i]), '.'.$level) || strpos(strtolower($h[$i]), $level.':')) {
                        $pattern = '/^\[(?P<date>(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}))\](?:.*?(?P<context>(\w+))\.|.*?)'.$level.': (?P<text>.*?)(?P<in_file> in .*?:[0-9]+)?$/i';
                        preg_match($pattern, $h[$i], $current);
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
    private function pathToLogFile(string $file): string
    {
        /** @var Filesystem $filesystem */
        $filesystem = app(Filesystem::class);

        $logsPath = storage_path('logs');

        if ($filesystem->exists($file)) {
            return $file;
        }

        $file = $logsPath . '/' . $file;

        if (dirname($file) !== $logsPath) {
            throw new Exception('No such log file');
        }

        return $file;
    }
}
