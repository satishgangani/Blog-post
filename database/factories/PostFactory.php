<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tags = Tag::select('id')->get()->toArray();
        
        return [
            'author_id' => User::inRandomOrder()->first()->id,
            'title' => ucwords($this->faker->unique()->word),
            'description' => '<p>'.$this->faker->paragraphs(5, true).'</p><p>'.$this->faker->paragraphs(5, true).'</p>',
            'tags' => genArrayFromArray($tags, rand(1, count($tags))),
            'post_date' => now(),
        ];
    }
}
