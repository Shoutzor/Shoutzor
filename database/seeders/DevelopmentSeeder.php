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
        // Create 10 dummy users
        $this->command->info("Generating users");
        User::factory()->count(10)->create();

        // Create 10 Albums
        $this->command->info("Generating albums");
        Album::factory()->count(10)->create();

        // Create 10 Artists and give each 0-10 albums
        $this->command->info("Generating artists");
        Artist::factory()
            ->count(10)
            ->hasAlbums(5)
            ->create();

        // Create 20 media items, each containing 0-10 artists and 0-10 albums
        $this->command->info("Generating Media items");
        Media::factory()
            ->count(20)
            ->hasAlbums(5)
            ->hasArtists(5)
            ->create();

        // Create some votes
        $this->command->info("Generating Votes");
        Vote::factory()
                ->count(20)
                ->create();

        // Create some requests
        $this->command->info("Generating Requests");
        Request::factory()
            ->count(10)
            ->create();

        // Create some history
        $this->command->info("Generating Request History");
        Request::factory()
            ->count(5)
            ->state(new Sequence(fn($sequence) => [
                'played_at' => Carbon::now()->addMinutes(random_int(-2000, 0))
            ]))
            ->create();
    }
}
