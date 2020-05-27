<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \RauweBieten\PhpFakerMusic\Dance($faker));

        $albumImageLocation = public_path('storage' . DIRECTORY_SEPARATOR . 'album' . DIRECTORY_SEPARATOR);
        $artistImageLocation = public_path('storage' . DIRECTORY_SEPARATOR . 'artist' . DIRECTORY_SEPARATOR);

        //
        // User
        //
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $users[] = DB::table('users')->insertGetId([
                'name' => $faker->userName,
                'email' => $faker->safeEmail,
                'password' => Hash::make($faker->password),
            ]);
        }

        //
        // Artist
        //
        $artists = [];
        for ($i = 0; $i < 20; $i++) {
            $artists[] = DB::table('artists')->insertGetId([
                'name' => $faker->musicDanceArtist(),
                'summary' => $faker->realText(200, 2),
                'image' => $faker->picsum($artistImageLocation, 640, 640, false),
            ]);
        }

        //
        // Album
        //
        $albums = [];
        for ($i = 0; $i < 10; $i++) {
            $albums[] = DB::table('albums')->insertGetId([
                'title' => $faker->musicDanceAlbum(),
                'summary' => $faker->realText(200, 2),
                'image' => $faker->picsum($albumImageLocation, 640, 640, false),
            ]);
        }

        //
        // AlbumArtist
        // Create relationships between Artist and Album
        // Every Album will get 2 Artists assigned to it
        //
        for ($i = 0; $i < 10; $i++) {
            DB::table('album_artist')->insert([
                ['album_id' => $albums[$i], 'artist_id' => $artists[$i * 2]],
                ['album_id' => $albums[$i], 'artist_id' => $artists[$i * 2 + 1]]
            ]);
        }

        //
        // Media
        //
        $trackTitles = [
            "Ghosts 'n Stuff",
            "Sweet but Psycho",
            "The veldt - 8 minute edit",
            "You shook me all night long",
            "Highway to hell",
            "Let there be rock",
            "Ride on / interviews",
            "Rock 'N' Roll Damnation",
            "Never gonna give you up",
            "Baba O'Riley"
        ];
        $tracks = [];
        for ($i = 0; $i < 10; $i++) {
            $tracks[] = DB::table('media')->insertGetId([
                'title' => $trackTitles[$i],
                'filename' => 'example.mp3',
                'crc' => 'invalid_crc_placeholder_hash',
                'duration' => $faker->numberBetween(30, 500),
                'source' => 'file'
            ]);
        }

        //
        // AlbumMedia
        // Create relationships between Album and Media
        // Every Media will get a single Album
        //
        for ($i = 0; $i < 10; $i++) {
            DB::table('album_media')->insert([
                'album_id' => $albums[$i],
                'media_id' => $tracks[$i]
            ]);
        }

        //
        // ArtistMedia
        // Create relationships between Artist and Album
        // Every Album will get 2 Artists assigned to it
        //
        for ($i = 0; $i < 10; $i++) {
            DB::table('artist_media')->insert([
                ['artist_id' => $artists[$i*2], 'media_id' => $tracks[$i]],
                ['artist_id' => $artists[$i*2+1], 'media_id' => $tracks[$i]]
            ]);
        }

        //
        // Request
        //
        for ($i = 0; $i < 4; $i++) {
            DB::table('requests')->insert([
                'user_id' => $users[$i],
                'media_id' => $tracks[$i]
            ]);
        }

        //Also create an AutoDJ request
        DB::table('requests')->insert([
            'user_id' => null,
            'media_id' => $tracks[4]
        ]);

        //
        // History
        //
        for ($i = 5; $i < 9; $i++) {
            DB::table('history')->insert([
                'user_id' => $users[$i],
                'media_id' => $tracks[$i]
            ]);
        }

        //Also create an AutoDJ history item
        DB::table('history')->insert([
            'user_id' => null,
            'media_id' => $tracks[9]
        ]);
    }
}
