<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'v_id',
        'account',
        'email',
        'password',
        'firstname',
        'middlename',
        'lastname',
        'phone_number',
        
        'wallet_id',
        'wallet_amount',
        'last_amount',
        'current_pay',
        'transaction_count',

        'sms_notification',
        'email_notification',
        'phone_status',
        'status',
        
        'banking_status',
        'bank_name',
        'bank_account_number',
        'verified_bank_user',

        'business_category',
        'business_address',
        'business_name',
        
        'NIN',
        'BVN',
        'NOK',
        'NOK_number',
        'NOK_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'BVN',
        'NIN',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

