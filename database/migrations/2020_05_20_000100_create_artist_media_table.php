<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'artist_media',
            function (Blueprint $table) {
                $table->foreignUuid('artist_id')->constrained('artists', 'id')->cascadeOnDelete();
                $table->foreignUuid('media_id')->constrained('media', 'id')->cascadeOnDelete();
                $table->unique(['artist_id', 'media_id']);
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
        Schema::dropIfExists('artist_media');
    }
}
