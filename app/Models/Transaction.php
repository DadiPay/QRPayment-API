<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'transaction_type',
        'transaction_reference',
        'transaction_amount',
        'transaction_date',
        'transaction_fee',
        'VAT',
        'corporate_fee',
        'sender_notification',
        'receiver_notification',

        'sender_previous_amount',
        'sender_new_amount',
        'receiver_previous_amount',

        'receiver_new_amount',
        'wallet_status',
        'transaction_status',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'transaction_fee',
        'VAT',


    ];
}
