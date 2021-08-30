<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'album_artist',
            function (Blueprint $table) {
                $table->foreignId('album_id')->constrained('albums', 'id')->cascadeOnDelete();
                $table->foreignId('artist_id')->constrained('artists', 'id')->cascadeOnDelete();
                $table->unique(['album_id', 'artist_id']);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_artist');
    }
}
