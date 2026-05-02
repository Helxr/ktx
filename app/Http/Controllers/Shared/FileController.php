<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Show private file (CCCD, etc.) via signed URL or admin auth.
     */
    public function showPrivateFile(Request $request, string $path): StreamedResponse
    {
        // Validate signed URL
        if (! URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired signed URL');
        }

        if (! Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return Storage::disk('private')->response($path);
    }

    /**
     * Generate signed URL for private file access
     */
    public static function generateSignedUrl(string $path, int $expiresInMinutes = 60): string
    {
        return URL::signedRoute('private.file', ['path' => $path], now()->addMinutes($expiresInMinutes));
    }
}


