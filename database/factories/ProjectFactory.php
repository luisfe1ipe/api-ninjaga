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
        return [
            'title' => fake()->title(),
            'synopsis' => fake()->text(),
            'slug' => fake()->slug(),
            'image' => fake()->imageUrl(),
            'published_at' => fake()->year(),
            'status' => fake()->randomElement(StatusProjectEnum::values()),
            'type_id' => Type::factory()
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
