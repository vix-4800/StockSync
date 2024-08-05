<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uniqueUsers = User::distinct()->inRandomOrder()->limit(2)->get('id');

        foreach ($uniqueUsers as $user) {
            $conversation = Conversation::factory()->create([
                'user_id' => $user->id,
                'admin_id' => Admin::first()->id,
            ]);

            $conversation->messages()->createMany(
                Message::factory()->count(3)->make()->toArray()
            );
        }
    }
}
