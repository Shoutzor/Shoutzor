<?php

namespace Database\Factories;

use App\Models\Request;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{

    protected $model = Vote::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'request_id' => function () {
                return Request::inRandomOrder()->whereNotNull('requested_by')->first()->id;
            }
        ];
    }
}
