<?php

namespace App\Jobs;

use App\Models\GeneratedPdf;
use App\Models\MarketplaceAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $imgHeight = 25;

    protected int $imgWidth = 37;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly MarketplaceAccount $marketplaceAccount
    ) {
        //
    }

    /**
     * Execute the job.
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
        Storage::disk('public')->put($file->file_name, '');
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
