<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomUserId = User::all()->random()->id;
        $randomCategoryId = Category::all()->random()->id;

        return [
            'user_id' => $randomUserId,
            'category_id' => $randomCategoryId,
            'title' => $this->faker->text($maxNbChars = 20),
            'excerpt' => $this->faker->paragraph,
            'body' => $this->faker->text($maxNbChars = 250),
            'slug' => $this->faker->slug,
        ];
    }
}
