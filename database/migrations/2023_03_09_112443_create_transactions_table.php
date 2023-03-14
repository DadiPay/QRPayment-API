<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sender_id');
            $table->string('receiver_id');
            $table->string('transaction_type');
            $table->string('transaction_reference');
            $table->double('transaction_amount');
            $table->timestamp('transaction_date');
            $table->double('transaction_fee');
            $table->double('VAT')->nullable();
            $table->integer('corporate_fee')->nullable();
            $table->integer('sender_notification')->defaule(0); // 0 not received notification, 1 received
            $table->integer('receiver_notification')->dafault(0); // 0 not received notification, 1 received
            $table->double('sender_previous_amount');
            $table->double('sender_new_amount');
            $table->double('receiver_previous_amount');
            $table->double('receiver_new_amount');
            $table->string('wallet_status')->default('not updated'); // check if the receivers wallet has been updated
            $table->string('transaction_status')->defaule(0);




            


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
