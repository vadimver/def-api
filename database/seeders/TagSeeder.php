<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTestTag();
    }

    protected function createTestTag()
    {
        $tags = ['Tag 1', 'Tag 2', 'Tag 3', 'Tag 4'];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
            ]);
        }

        $posts = Post::all();
        $tags = Tag::all();

        $posts->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(0, $tags->count()))->pluck('id')->toArray()
            );
        });
    }
}
