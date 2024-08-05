<?php

declare(strict_types=1);

namespace App\Actions\Pdf;

use TCPDF;

class InitPdf
{
    /**
     * Initializes a new pdf file with the specified page layout and font size.
     *
     * @param  array  $pageLayout  The dimensions of the page layout in millimeters. Default is [58, 40].
     * @param  int  $fontSize  The font size in points. Default is 8.
     * @return TCPDF The initialized pdf file.
     */
    public static function handle(array $pageLayout = [58, 40], int $fontSize = 8): TCPDF
    {
        $pdf = new TCPDF('L', PDF_UNIT, $pageLayout, true, 'UTF-8', false);

        $pdf->SetCreator(config('app.name'));
        $pdf->SetAuthor(config('app.name'));
        $pdf->SetTitle('Supply stickers');
        $pdf->SetSubject('Supply stickers');
        $pdf->SetKeywords(config('app.name').', Supply, Supplies, Stickers, pdf');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetMargins(0, 0, 0);

        $pdf->SetFont('dejavusans', '', $fontSize);

        return $pdf;
    }
}
