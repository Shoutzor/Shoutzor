<?php

namespace Database\Factories;

use App\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class AlbumFactory extends Factory
{

    protected $model = Album::class;
    protected string $albumImageLocation;

    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null
    ) {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);

        $this->albumImageLocation = storage_path('app/public/album');
    }

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'summary' => $this->faker->paragraph(),
            'image' => $this->faker->image($this->albumImageLocation, 640, 640, false),
        ];
    }
}