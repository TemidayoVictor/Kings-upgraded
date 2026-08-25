<?php

namespace App\Services\Logging;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

class LogViewerService
{
    private const LOG_PATTERN = '/^\[(?<timestamp>[\d\-:\s]+)\]\s+(?<environment>[a-zA-Z0-9_-]+)\.(?<level>[A-Z]+):\s*(?<message>.*)$/';

    public function availableDates(): Collection
    {
        $directory = storage_path('logs');

        if (! File::isDirectory($directory)) {
            return collect();
        }

        return collect(File::files($directory))
            ->filter(function ($file) {
                return preg_match(
                    '/^laravel-\d{4}-\d{2}-\d{2}\.log$/',
                    $file->getFilename()
                );
            })
            ->map(function ($file) {
                preg_match(
                    '/^laravel-(\d{4}-\d{2}-\d{2})\.log$/',
                    $file->getFilename(),
                    $matches
                );

                return $matches[1];
            })
            ->sortDesc()
            ->values();
    }

    public function getLogFile(string $date): string
    {
        $this->validateDate($date);

        $path = storage_path("logs/laravel-{$date}.log");

        if (! File::exists($path)) {
            throw new RuntimeException('Log file does not exist.');
        }

        return $path;
    }

    public function search(
        string $date,
        string $search = '',
        string $level = 'all',
        int $page = 1,
        int $perPage = 50,
    ): array {
        $path = $this->getLogFile($date);

        $entries = $this->readEntries($path);

        $search = trim($search);
        $level = strtoupper($level);

        $filtered = $entries->filter(function (array $entry) use ($search, $level) {
            if ($level !== 'ALL' && $entry['level'] !== $level) {
                return false;
            }

            if ($search !== '') {
                return str_contains(
                    strtolower($entry['raw']),
                    strtolower($search)
                );
            }

            return true;
        });

        $total = $filtered->count();

        $items = $filtered
            ->reverse()
            ->values()
            ->forPage($page, $perPage)
            ->values();

        return [
            'items' => $items,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function findByIndex(
        string $date,
        int $index,
        string $search = '',
        string $level = 'all',
    ): ?array {
        $result = $this->search(
            date: $date,
            search: $search,
            level: $level,
            page: 1,
            perPage: PHP_INT_MAX,
        );

        return $result['items']->get($index);
    }

    public function clear(string $date): void
    {
        $path = $this->getLogFile($date);

        if (! is_writable($path)) {
            throw new RuntimeException('Log file is not writable.');
        }

        file_put_contents($path, '');
    }

    public function size(string $date): int
    {
        $path = $this->getLogFile($date);

        return File::size($path);
    }

    public function lastModified(string $date): Carbon
    {
        $path = $this->getLogFile($date);

        return Carbon::createFromTimestamp(File::lastModified($path));
    }

    private function readEntries(string $path): Collection
    {
        $entries = collect();

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Unable to open log file.');
        }

        $currentEntry = null;

        while (($line = fgets($handle)) !== false) {
            $line = rtrim($line, "\r\n");

            if (preg_match(self::LOG_PATTERN, $line, $matches)) {
                if ($currentEntry !== null) {
                    $entries->push($currentEntry);
                }

                $currentEntry = [
                    'timestamp' => $matches['timestamp'],
                    'environment' => $matches['environment'],
                    'level' => $matches['level'],
                    'message' => $matches['message'],
                    'raw' => $line,
                ];
            } elseif ($currentEntry !== null) {
                $currentEntry['raw'] .= "\n" . $line;
                $currentEntry['message'] .= "\n" . $line;
            }
        }

        if ($currentEntry !== null) {
            $entries->push($currentEntry);
        }

        fclose($handle);

        return $entries;
    }

    private function validateDate(string $date): void
    {
        try {
            $parsed = Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Throwable) {
            throw new RuntimeException('Invalid log date.');
        }

        if (! $parsed || $parsed->format('Y-m-d') !== $date) {
            throw new RuntimeException('Invalid log date.');
        }
    }
}
