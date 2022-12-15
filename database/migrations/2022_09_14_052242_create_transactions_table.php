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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('guest_id')->constrained();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('transaction_type_id')->constrained();
            $table->string('payable_amount');
            $table->string('paid_amount')->nullable();
            $table->string('change_amount')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->string('override_at')->nullable();
            $table->text('assigned_frontdesks')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
