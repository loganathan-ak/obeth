<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
        protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'file',
        'created_by',
        'obeth_id',
        'company_name',
    ];
}
