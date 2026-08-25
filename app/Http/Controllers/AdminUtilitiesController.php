<?php

namespace App\Http\Controllers;

use App\Services\Logging\LogViewerService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminUtilitiesController extends Controller
{
    public function downloadLogs(LogViewerService $logViewer): BinaryFileResponse
    {
        $date = request()->string('date')->toString();
        $path = $logViewer->getLogFile($date);

        return response()->download(
            $path,
            "laravel-{$date}.log",
            [
                'Content-Type' => 'text/plain',
            ]
        );
    }
}
