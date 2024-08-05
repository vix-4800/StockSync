<?php

use App\Enums\InvitationStatus;
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
        Schema::create('employee_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->foreignIdFor(Team::class)->cascadeOnDelete();
            $table->string('token', 32)->unique();
            $table->enum('status', InvitationStatus::values())->default(InvitationStatus::PENDING);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['email', 'team_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_invitations');
    }
};
