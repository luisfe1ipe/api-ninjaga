<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super-admin@ninjaga.com',
        ]);
        $user->assignPermission('super-admin');

        Genre::factory(20)->create();
        Author::factory(10)->create();
        Artist::factory(10)->create();
        Project::factory(50)->create();
    }
}
