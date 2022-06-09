<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{

    protected $model = Vote::class;

    public function definition()
    {
        return [
            'user_id' => function() {
                return User::inRandomOrder()->first()->id;
            },
            'media_id' => function() {
                return Media::inRandomOrder()->first()->id;
            }
        ];
    }
}
