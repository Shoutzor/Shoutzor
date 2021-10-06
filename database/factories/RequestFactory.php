<?php

namespace Database\Factories;

use App\Media;
use App\Request;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{

    protected $model = Request::class;

    public function definition()
    {
        return [
            'media_id' => function() {
                return Media::inRandomOrder()->first()->id;
            }
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Request $request) {
            $users = User::inRandomOrder()->limit(random_int(0,5))->get();
            $request->users()->saveMany($users);
        });
    }
}