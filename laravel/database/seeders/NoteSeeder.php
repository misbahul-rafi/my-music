<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->info('Please create some users first!');
            return;
        }
        foreach ($users as $user) {
            Note::factory()->count(5)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
