<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'votes',
            function (Blueprint $table) {
                $table->foreignUuid('request_id')->references('id')->on('requests')->onDelete('cascade');
                $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->primary(['request_id', 'user_id'], 'votes_request_id_user_id_primary');
                $table->timestamp('voted_at')->useCurrent();
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
        Schema::dropIfExists('votes');
    }
}
