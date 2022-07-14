<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomUserId = User::all()->random()->id;
        $randomPostId = Post::all()->random()->id;

        return [
            'user_id' => $randomUserId,
            'post_id' => $randomPostId,
            'body' => $this->faker->text($maxNbChars = 50),
        ];
    }
}
