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
                $table->uuid('id')->primary();
                $table->foreignUuid('media_id')->constrained('media', 'id')->cascadeOnDelete();
                $table->foreignUuid('requested_by')->nullable()->constrained('users', 'id')->nullonDelete();
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
