<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'order_id',
        'sender_id',
        'receiver_id',
        'message',
    ];
}
