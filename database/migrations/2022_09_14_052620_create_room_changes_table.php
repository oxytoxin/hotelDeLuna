<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained();
            $table->unsignedBigInteger('from_room_id')->references('id')->on('rooms');
            $table->unsignedBigInteger('to_room_id')->references('id')->on('rooms');
            $table->string('reason');
            $table->string('amount');
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
        Schema::dropIfExists('room_changes');
    }
};
