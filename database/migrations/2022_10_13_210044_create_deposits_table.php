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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained();
            $table->string('amount');
            $table->string('deducted')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('retrieved')->default(false);
            $table->string('front_desk_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('deposits');
    }

    //

    // public function deposit()
    // {
    //     Deposit::create([
    //         'transaction_id'=>$checkindeposit->id,
    //         'amount'=>200,
    //         'remarks'=>'Deposit for remote and key'
    //     ]);
    // }
};
