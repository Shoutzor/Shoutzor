<?php

namespace Database\Seeders;

use App\User;
use Exception;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        // Create 30 dummy users
        User::factory()->count(30)->create();

        /*
         *
         * All of the code below will be moved to their own module(s).
         *

        // Create 10 Albums
        Album::factory()->count(20)->create();

        // Create 20 Artists and give each 0-10 albums
        Artist::factory()
            ->count(20)
            ->state(
                new Sequence(
                    fn() => ['albums' => Album::all()->random(random_int(0, 10))]
                )
            )
            ->create();

        // Create 50 media items, each containing 0-10 artists and 0-10 albums
        Media::factory()->count(50)->state(
            new Sequence(
                fn() => [
                    'albums' => Album::all()->random(random_int(0, 10)),
                    'artists' => fn() => Artist::all()->random(random_int(0, 10))
                ]
            )
        )->create();

        // Create some requests
        Request::factory()->count(20)->state(
            new Sequence(
                fn() => [
                    'user' => (random_int(0, 2) === 0 ? null : User::all()->random(1)),
                    'media' => Media::all()->random(1)
                ]
            )
        )->create();

        // Create some history
        Request::factory()->count(20)->state(
            new Sequence(
                fn() => [
                    'user' => (random_int(0, 2) === 0 ? null : User::all()->random(1)),
                    'media' => Media::all()->random(1),
                    'played_at' => Carbon::now()->addMinutes(random_int(-2000, 0))
                ]
            )
        )->create();*/
    }
}
