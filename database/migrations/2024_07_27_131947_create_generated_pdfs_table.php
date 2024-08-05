<?php

use App\Models\MarketplaceAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generated_pdfs', function (Blueprint $table) {
            $table->id();

            $table->string('file_name');
            $table->foreignIdFor(MarketplaceAccount::class)->cascadeOnDelete();
            $table->string('supply_numbers', 25)->nullable()->default(null);
            $table->string('supply_dates', 25)->nullable()->default(null);
            $table->integer('sticker_count');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_pdfs');
    }
};
