<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomUserId = User::all()->random()->id;
        $likeable = $this->faker->randomElement([
            Post::class,
            Comment::class,
        ]);

        return [
            'user_id' => $randomUserId,
            'likeable_id' => $likeable::factory(),
            'likeable_type' => $likeable,
        ];
    }
}
