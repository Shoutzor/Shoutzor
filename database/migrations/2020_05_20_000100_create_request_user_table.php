<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'request_user',
            function (Blueprint $table) {
                $table->foreignUuid('request_id')->constrained('requests', 'id')->cascadeOnDelete();
                $table->foreignUuid('user_id')->constrained('users', 'id')->cascadeOnDelete();
                $table->unique(['request_id', 'user_id']);
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
        Schema::dropIfExists('request_user');
    }
}
