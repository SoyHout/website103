<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;
use Rawilk\Printing\Facades\Printing;

class PrinterController extends Controller
{
    public function printReceipt()
    {
        $code = '1234';
        $pdfPath = $this->createReceiptPdf($code);

        try {
            $printJob = Printing::newPrintTask()
                ->printer(config('printing.default_printer_id'))
                ->file($pdfPath)
                ->send();

            return response()->json([
                'status' => 'sent',
                'printer_id' => config('printing.default_printer_id'),
                'print_job_id' => $printJob->id(),
                'state' => $printJob->state(),
            ]);
        } catch (\Exception $e) {
            Log::error('Print error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        } finally {
            if (file_exists($pdfPath)) {
                @unlink($pdfPath);
            }
        }
    }

    protected function createReceiptPdf(string $code): string
    {
        $jpegPath = $this->createBarcodeJpeg($code);
        $pdfPath = tempnam(sys_get_temp_dir(), 'printnode_') . '.pdf';

        $this->savePdfWithBarcode($pdfPath, $jpegPath, $code);

        @unlink($jpegPath);

        return $pdfPath;
    }

    protected function createBarcodeJpeg(string $code): string
    {
        $width = 500;
        $height = 160;

        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        $pattern = $this->code39Pattern($code);
        $x = 10;
        $barHeight = 100;

        foreach ($pattern as $segment) {
            if ($segment['bar']) {
                imagefilledrectangle($image, $x, 20, $x + $segment['width'] - 1, 20 + $barHeight, $black);
            }

            $x += $segment['width'];
        }

        imagestring($image, 5, 10, 125, "*{$code}*", $black);

        $path = tempnam(sys_get_temp_dir(), 'barcode_') . '.jpg';
        imagejpeg($image, $path, 90);
        imagedestroy($image);

        return $path;
    }

    protected function savePdfWithBarcode(string $pdfPath, string $jpegPath, string $code): void
    {
        $imageBase64 = base64_encode(file_get_contents($jpegPath));

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .receipt { width: 80mm; margin: 0 auto; }
                .header { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 10px; }
                .items { font-size: 11px; margin-bottom: 10px; }
                .item { margin: 5px 0; }
                .barcode { text-align: center; margin: 10px 0; }
                .barcode img { width: 100%; height: auto; }
                .code { text-align: center; font-size: 10px; margin-top: 5px; }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="header">MY STORE</div>
                <div class="items">
                    <div class="item">Item 1 ..................... 2.00</div>
                    <div class="item">Item 2 ..................... 4.00</div>
                </div>
                <div class="barcode">
                    <img src="data:image/jpeg;base64,{$imageBase64}" alt="Barcode">
                </div>
                <div class="code">{$code}</div>
            </div>
        </body>
        </html>
        HTML;

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($pdfPath, $dompdf->output());
    }

    protected function code39Pattern(string $code): array
    {
        $map = [
            '0' => 'nnnwwnwnn',
            '1' => 'wnnwnnnnw',
            '2' => 'nnwwnnnnw',
            '3' => 'wnwwnnnnn',
            '4' => 'nnnwwnnnw',
            '5' => 'wnnwwnnnn',
            '6' => 'nnwwwnnnn',
            '7' => 'nnnwnnwnw',
            '8' => 'wnnwnnwnn',
            '9' => 'nnwwnnwnn',
            'A' => 'wnnnnwnnw',
            'B' => 'nnwnnwnnw',
            'C' => 'wnwnnwnnn',
            'D' => 'nnnnwwnnw',
            'E' => 'wnnnwwnnn',
            'F' => 'nnwnwwnnn',
            'G' => 'nnnnnwwnw',
            'H' => 'wnnnnwwnn',
            'I' => 'nnwnnwwnn',
            'J' => 'nnnnwwwnn',
            'K' => 'wnnnnnnww',
            'L' => 'nnwnnnnww',
            'M' => 'wnwnnnnwn',
            'N' => 'nnnnwnnww',
            'O' => 'wnnnwnnwn',
            'P' => 'nnwnwnnwn',
            'Q' => 'nnnnnnwww',
            'R' => 'wnnnnnwwn',
            'S' => 'nnwnnnwwn',
            'T' => 'nnnnwnwwn',
            'U' => 'wwnnnnnnw',
            'V' => 'nwwnnnnnw',
            'W' => 'wwwnnnnnn',
            'X' => 'nwnnwnnnw',
            'Y' => 'wwnnwnnnn',
            'Z' => 'nwwnwnnnn',
            '-' => 'nwnnnnwnw',
            '.' => 'wwnnnnwnn',
            ' ' => 'nwwnnnwnn',
            '$' => 'nwnwnwnnn',
            '/' => 'nwnwnnnwn',
            '+' => 'nwnnnwnwn',
            '%' => 'nnnwnwnwn',
            '*' => 'nwnnwnwnn',
        ];

        $value = '*' . strtoupper($code) . '*';
        $result = [];

        foreach (str_split($value) as $index => $character) {
            $pattern = $map[$character] ?? $map['*'];

            foreach (str_split($pattern) as $i => $letter) {
                $result[] = [
                    'bar' => $i % 2 === 0,
                    'width' => $letter === 'w' ? 4 : 2,
                ];
            }

            if ($index !== array_key_last(str_split($value))) {
                $result[] = [
                    'bar' => false,
                    'width' => 4,
                ];
            }
        }

        return $result;
    }
}
