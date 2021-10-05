<?php

namespace Database\Seeders;

use App\Album;
use App\Artist;
use App\Media;
use App\Request;
use App\User;
use App\Vote;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
        /*// Create 10 dummy users
        User::factory()->count(10)->create();

        // Create 10 Albums
        Album::factory()->count(10)->create();

        // Create 10 Artists and give each 0-10 albums
        Artist::factory()
            ->count(10)
            ->hasAlbums(5)
            ->create();

        // Create 20 media items, each containing 0-10 artists and 0-10 albums
        Media::factory()
            ->count(20)
            ->hasAlbums(5)
            ->hasArtists(5)
            ->create();

        // Create some votes
        Vote::factory()
                ->count(20)
                ->create();

        // Create some requests
        Request::factory()
            ->count(10)
            ->create();*/

        // Create some history
        Request::factory()
               ->count(5)
                ->hasUsers(3)
                ->state(new Sequence(fn($sequence) => [
                    'played_at' => Carbon::now()->addMinutes(random_int(-2000, 0))
                ]))
               ->create();
    }
}
