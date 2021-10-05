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
            'title' => $this->faker->realTextBetween(8, 40),
            'filename' => 'example.mp3', //TODO: use $this->faker->file() ?
            'duration' => $this->faker->numberBetween(30, 500),
            'hash' => hash('sha512', $this->faker->text(50)),
            'is_video' => false
        ];
    }
}