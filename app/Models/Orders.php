<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'project_title',
        'request_type',
        'other_request_type',
        'instructions',
        'colors',
        'size',
        'other_size',
        'software',
        'other_software',
        'brands_profile_id',
        'formats',
        'pre_approve',
        'reference_files',
        'rush',
        'created_by',
        'obeth_id',
        'assigned_to',
        'status',
    ];
    
}
