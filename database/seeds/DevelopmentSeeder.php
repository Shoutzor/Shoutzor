<?php

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
        $faker = Faker\Factory::create();
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \RauweBieten\PhpFakerMusic\Dance($faker));

        $publicStorageLocation = storage_path('app/public');
        $albumImageLocation = storage_path('app/public/album');
        $artistImageLocation = storage_path('app/public/artist');

        if(file_exists($publicStorageLocation) && is_writeable($publicStorageLocation)) {
            if(!file_exists($albumImageLocation)) {
                mkdir($albumImageLocation);
            }

            if(!file_exists($artistImageLocation)) {
                mkdir($artistImageLocation);
            }
        } else {
            throw new Exception("Directory is not writeable: " . $publicStorageLocation);
        }

        //
        // User
        //
        $users = [];

        echo "Creating (50) users..\n";

        for ($i = 0; $i < 50; $i++) {
            echo "Creating user $i/50..\n";

            $users[] = DB::table('users')->insertGetId([
                'username' => $faker->userName,
                'email' => $faker->safeEmail,
                'password' => Hash::make($faker->password),
            ]);
        }

        //
        // Artist
        //
        $artists = [];
        echo "Creating (20) artists..\n";

        for ($i = 0; $i < 20; $i++) {
            echo "Creating artist $i/20..\n";

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
        echo "Creating (10) albums..";

        for ($i = 0; $i < 10; $i++) {
            echo "Creating album $i/10..\n";
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
        echo "Creating (10) media items..\n";

        for ($i = 0; $i < 10; $i++) {
            echo "Creating media $i/10..\n";
            $tracks[] = DB::table('media')->insertGetId([
                'title' => $trackTitles[$i],
                'filename' => 'example.mp3',
                'crc' => 'invalid_crc_placeholder_hash',
                'duration' => $faker->numberBetween(30, 500),
                'is_video' => false
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

        //Create a request that has been played 3 minutes ago
        DB::table('requests')->insert([
            'user_id' => $users[1],
            'media_id' => $tracks[4],
            'played_at' => \Carbon\Carbon::now()->addMinutes(-3)
        ]);

        //Create a request that has been played just now
        DB::table('requests')->insert([
            'user_id' => null,
            'media_id' => $tracks[2],
            'played_at' => \Carbon\Carbon::now()
        ]);

    }
}
