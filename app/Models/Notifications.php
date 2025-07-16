<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    Protected $fillable = [
       'client_id',
       'message',
       'purpose',
       'order_id',
       'superadmin_id',
       'designer_id',
    ];
}
