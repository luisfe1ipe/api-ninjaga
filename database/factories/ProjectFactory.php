<?php

namespace Database\Factories;

use App\Enums\StatusProjectEnum;
use App\Models\Artist;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            'https://dsectcomics.org/wp-content/uploads/2023/12/cover-1-1-1.jpg',
            'https://dsectcomics.org/wp-content/uploads/2024/05/infiniteGachaCover03.png',
            'https://dsectcomics.org/wp-content/uploads/2024/05/ORV03.jpg',
            'https://dsectcomics.org/wp-content/uploads/2024/06/MystMightMayhemCover01.png',
            'https://dsectcomics.org/wp-content/uploads/2024/06/StarEmbracingSwordmasterCover01.png',
            'https://dsectcomics.org/wp-content/uploads/2023/12/swordmastersyoungestCover02.png',
            'https://dsectcomics.org/wp-content/uploads/2024/05/TWAE.jpg',
            'https://dsectcomics.org/wp-content/uploads/2024/06/LWGCover.jpg',
            'https://dsectcomics.org/wp-content/uploads/2024/05/MaxeLevelPlayer.jpg',
            'https://dsectcomics.org/wp-content/uploads/2024/05/SL.jpg',
        ];

        return [
            'title' => fake()->sentence(),
            'synopsis' => fake()->text(),
            'slug' => fake()->slug(),
            'image' => $images[array_rand($images)],
            'published_at' => fake()->year(),
            'status' => fake()->randomElement(StatusProjectEnum::values()),
            'type_id' => Type::factory(),
            'views' => fake()->numberBetween(400, 999999)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            $genres = Genre::factory()->count(rand(1, 3))->create();
            $project->genres()->attach($genres->pluck('id')->toArray());

            $authors = Author::factory()->count(rand(1, 2))->create();
            $project->authors()->attach($authors->pluck('id')->toArray());

            $artists = Artist::factory()->count(rand(1, 2))->create();
            $project->artists()->attach($artists->pluck('id')->toArray());
        });
    }
}
