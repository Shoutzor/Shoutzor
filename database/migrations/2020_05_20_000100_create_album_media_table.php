<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'album_media',
            function (Blueprint $table) {
                $table->foreignId('album_id')->constrained('albums', 'id')->cascadeOnDelete();
                $table->foreignId('media_id')->constrained('media', 'id')->cascadeOnDelete();
                $table->unique(['album_id', 'media_id']);
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
        Schema::dropIfExists('album_media');
    }
}
