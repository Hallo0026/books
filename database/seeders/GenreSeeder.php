<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/genres.json'));
        $genres = json_decode($json, true);

        foreach ($genres as $genre) {
            DB::table('genres')->insert($genre);
        }
    }
}
