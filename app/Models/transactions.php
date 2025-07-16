<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plans;

class Transactions extends Model
{

    protected $fillable = [
        'user_id',
        'plan_id',
        'credits_purchased',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'validity_days',
        'expire_date',
        'status',
        'paypal_data',
        'subscription_id',
    ];



    

}
