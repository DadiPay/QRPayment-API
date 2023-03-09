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

        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('u_id');
            $table->string('account')->unique();
            $table->string('email')->unique;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('fullname');
            $table->integer('phone_number');


            $table->string('bank_name')->nullable();
            $table->integer('bank_account_number')->nullable();
            $table->string('verified_bank_user')->nullable();

            $table->integer('NIN')->unique()->nullable();
            $table->integer('BVN')->unique()->nullable();
            $table->string('NOK')->nullable(); // Next of kin
            $table->integer('NOK_number')->nullable();
            $table->string('NOK_address')->nullable();


            $table->string('transaction_count')->nullable();
            $table->double('wallet_amount')->default(100);
            $table->string('wallet_id')->unique()->nullable();
            $table->double('last_amount')->nullable();
            $table->double('current_pay')->nullable();


            $table->string('phone_status')->default(0); // 1 activated, 0 not activated,
            $table->string('status')->default(0); // 0 Active 1 suspended, 2 no withdrawal,  
            $table->string('sms_notification')->nullable();
            $table->string('email_notification')->nullable();

            $table->string('role')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
