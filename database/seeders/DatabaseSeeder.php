<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
        ]);

        Task::factory(5)->create(['user_id' => $admin->id]);
        Task::factory(10)->create(['user_id' => $user->id]);

        // one task due tomorrow so we can test the reminder job
        Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'due_date' => now()->addDay()->toDateString(),
        ]);
    }
}
