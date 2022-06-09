<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class MediaFactory extends Factory
{

    protected $model = Media::class;
    protected string $mediaImageLocation;

    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null
    )
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
        $this->mediaImageLocation = storage_path('app/public/media');
    }

    private function coinflip() {
        try {
            return random_int(0, 1) === 1;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function definition()
    {
        return [
            'title' => $this->faker->realTextBetween(8, 50),
            'filename' => 'example.mp3', //TODO: use $this->faker->file() ?
            'duration' => $this->faker->numberBetween(30, 500),
            'hash' => hash('sha512', $this->faker->text(50)),
            'image' => $this->coinflip() ? '' : 'media/' . $this->faker->image($this->mediaImageLocation, 640, 640, '', false),
            'is_video' => false,
            'album_id' => Album::inRandomOrder()->first()->id
        ];
    }
}
