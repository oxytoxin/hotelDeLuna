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
        Schema::create('check_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('rate_id');
            $table->string('static_amount');
            $table->string('static_hours_stayed');
            $table->dateTime('check_in_at')->nullable();
            $table->dateTime('expected_check_out_at')->nullable();
            $table->dateTime('check_out_at')->nullable();
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
        Schema::dropIfExists('check_in_details');
    }
};
