<?php

use App\Enums\Marketplace;
use App\Models\Team;
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

            $table->foreignIdFor(Team::class)->cascadeOnDelete();
            $table->string('name');
            $table->enum('marketplace', Marketplace::values());
            $table->text('api_token');
            $table->string('api_user_id')->nullable();
            $table->date('api_token_created_at')->nullable();
            $table->date('api_token_expires_at')->nullable();

            $table->unique(['team_id', 'name', 'marketplace']);

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
