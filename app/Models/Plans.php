<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    // app/Models/Plan.php

    protected $fillable = [
        'name',
        'credits',
        'price',
        'description',
        'is_active',
        'validity_days',
    ];

}
