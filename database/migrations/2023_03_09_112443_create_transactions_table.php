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
            $table->string('v_id');
            $table->string('account')->unique();
            $table->string('email')->nullable()->unique;
            $table->string('password');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->integer('phone_number');

            
            $table->string('banking_status')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('bank_account_number')->nullable();
            $table->string('verified_bank_user')->nullable();

            $table->string('business_category')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_name')->nullable();

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
