<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'requests',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('media_id')->constrained('media', 'id')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
                $table->timestamp('requested_at')->useCurrent();
                $table->timestamp('played_at')->nullable()->default(null);
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
