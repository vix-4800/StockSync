<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\Pdf\InitPdf;
use App\Actions\Pdf\SavePdf;
use App\Models\GeneratedPdf;
use App\Models\MarketplaceAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly MarketplaceAccount $marketplaceAccount
    ) {
        //
    }

    /**
     * Generate the pdf file.
     */
    public function handle(): void
    {
        try {
            $file = $this->createFileInDatabase();
            $this->createFileInStorage($file);
        } catch (\Throwable $th) {
        }
    }

    private function createFileInStorage(GeneratedPdf $file): void
    {
        $pdf = InitPdf::handle();

        SavePdf::handle($pdf, $file->file_name);
    }

    private function createFileInDatabase(): GeneratedPdf
    {
        return GeneratedPdf::create([
            'file_name' => 'sticker-'.time(),
            'marketplace_account_id' => $this->marketplaceAccount->id,
            'supply_numbers' => 'WB-GI-96716498',
            'sticker_count' => 10,
        ]);
    }
}
