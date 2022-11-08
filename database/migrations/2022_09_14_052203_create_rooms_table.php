<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('floor_id');
            $table->string('number');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('room_status_id');
            $table->dateTime('time_to_clean')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->dateTime('time_to_terminate_in_queue')->nullable();
            $table->boolean('priority')->default(false);
            $table->dateTime('last_check_out_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
