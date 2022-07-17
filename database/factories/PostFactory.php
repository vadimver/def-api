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
        $userId = User::all()->random()->id;
        $categoryId = Category::all()->random()->id;

        return [
            'user_id' => $userId,
            'category_id' => $categoryId,
            'title' => $this->faker->text($maxNbChars = 20),
            'excerpt' => $this->faker->paragraph,
            'body' => $this->faker->text($maxNbChars = 250),
            'slug' => $this->faker->slug,
        ];
    }
}
