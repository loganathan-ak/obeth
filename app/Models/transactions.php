<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{

    protected $fillable = [
        'user_id',
        'plan_id',
        'credits_purchased',
        'amount_paid',
        'payment_method',
        'transaction_id',
    ];

}
