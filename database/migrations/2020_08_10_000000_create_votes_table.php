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
                $table->uuid('id')->primary();
                $table->foreignUuid('media_id')->constrained('media', 'id')->cascadeOnDelete();
                $table->foreignUuid('user_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('requests');
    }
}
