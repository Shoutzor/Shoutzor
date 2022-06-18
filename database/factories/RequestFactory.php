<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RequestFactory extends Factory
{

    protected $model = Request::class;

    public function definition()
    {
        return [
            'media_id' => function () {
                return Media::inRandomOrder()->first()->id;
            },
            'requested_by' => function () {
                return null;
            },
            'played_at' => function () {
                return null;
            }
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Request $request) {
            $request->requested_by = (random_int(0, 5) > 3) ? null : User::inRandomOrder()->first()->id;
            $request->save();
        });
    }
}
