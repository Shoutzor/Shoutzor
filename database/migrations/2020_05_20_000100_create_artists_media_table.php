<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists_media', function (Blueprint $table) {
            $table->integer('artist_id')->unsigned();
            $table->foreign('artist_id')->references('id')->on('artists')->cascadeOnDelete();

            $table->integer('media_id')->unsigned();
            $table->foreign('media_id')->references('id')->on('media')->cascadeOnDelete();

            $table->unique(['artist_id', 'media_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists_media');
    }
}
