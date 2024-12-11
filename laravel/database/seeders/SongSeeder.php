<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Song::create([
            'user_id' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=example1',
            'title' => 'Example Song 1',
            'file_path' => '/path/to/song1.mp3',
            'thumbnail_url' => 'https://img.youtube.com/vi/example1/default.jpg',
            'duration' => 225,
            'download_status' => 'completed',
        ]);

        Song::create([
            'user_id' => 4,
            'youtube_url' => 'https://www.youtube.com/watch?v=example2',
            'title' => 'Example Song 2',
            'file_path' => '/path/to/song2.mp3',
            'thumbnail_url' => 'https://img.youtube.com/vi/example2/default.jpg',
            'duration' => 252,
            'download_status' => 'completed',
        ]);
    }
}
