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
        Schema::create('room_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->string('room_number');
            $table->foreignId('check_in_detail_id')->constrained();
            $table->dateTime('check_in_at');
            $table->dateTime('check_out_at')->nullable();
            $table->boolean('guest_transfered')->default(false);
            $table->string('time_interval');
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
        Schema::dropIfExists('room_transaction_logs');
    }
};
