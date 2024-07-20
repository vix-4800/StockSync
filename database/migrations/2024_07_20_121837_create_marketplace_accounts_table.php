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
        Schema::create('marketplace_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->cascadeOnDelete();
            $table->string('name');
            $table->enum('marketplace', Marketplace::values());
            $table->string('api_token');
            $table->string('api_user_id')->nullable();
            $table->timestamp('api_token_expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_accounts');
    }
};
