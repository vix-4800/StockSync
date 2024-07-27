<?php

use App\Enums\Marketplace;
use App\Models\User;
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
        Schema::create('deep_links', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->cascadeOnDelete();
            $table->string('name');
            $table->enum('marketplace', Marketplace::values());
            $table->string('generated_url')->unique();
            $table->boolean('is_archived')->default(false);
            $table->string('qr_code');
            $table->text('options')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deep_links');
    }
};
