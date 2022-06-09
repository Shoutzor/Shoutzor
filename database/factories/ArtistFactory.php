<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class ArtistFactory extends Factory
{

    protected $model = Artist::class;
    protected string $artistImageLocation;

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

        $this->artistImageLocation = storage_path('app/public/artist');
    }

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'summary' => $this->faker->paragraph(),
            'image' => 'artist/' . $this->faker->image($this->artistImageLocation, 640, 640, 'nightlife', false),
        ];
    }
}
