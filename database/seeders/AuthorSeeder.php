<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/authors.json'));
        $authors = json_decode($json, true);

        foreach ($authors as $author) {
            DB::table('authors')->insert($author);
        }
    }
}
