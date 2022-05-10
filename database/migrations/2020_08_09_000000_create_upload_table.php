<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'uploads',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('filename');
                $table->foreignUuid('user_id')->constrained('users', 'id')->cascadeOnDelete();
                $table->smallInteger('status')->unsigned();
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
        Schema::dropIfExists('uploads');
    }
}
