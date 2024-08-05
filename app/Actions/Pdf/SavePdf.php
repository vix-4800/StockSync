<?php

declare(strict_types=1);

namespace App\Actions\Pdf;

use Storage;
use TCPDF;

class SavePdf
{
    /**
     * Saves the pdf file to the specified path in the specified storage (public by default).
     *
     * @param  TCPDF  $pdf  The pdf file to save.
     * @param  string  $path  The path to save the PDF file to.
     */
    public static function handle(TCPDF $pdf, string $path, string $storage = 'public'): void
    {
        $pdf->Output(Storage::disk($storage)->path($path), 'F');
    }
}
