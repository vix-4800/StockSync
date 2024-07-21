<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Team;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::create([
            'name' => 'Team 1',
            'email' => 'team@localhost',
            'phone' => $this->faker->phoneNumber,
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@localhost',
            'password' => bcrypt('manager'),
            'team_id' => $team->id,
            'role' => UserRole::MANAGER->value,
        ]);

        User::create([
            'name' => 'User 1',
            'email' => 'user@localhost',
            'password' => bcrypt('user'),
            'team_id' => $team->id,
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@localhost',
            'password' => bcrypt('user'),
            'team_id' => $team->id,
        ]);
    }
}
