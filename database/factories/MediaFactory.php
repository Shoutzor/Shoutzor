<?php

namespace Database\Factories;

use App\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{

    protected $model = Media::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'filename' => 'example.mp3', //TODO: use $this->faker->file()
            'duration' => $this->faker->numberBetween(30, 500),
            'hash' => hash_file('sha512', 'filename_here'),
            'is_video' => false,
            'source' => 'audio'
        ];
    }
}