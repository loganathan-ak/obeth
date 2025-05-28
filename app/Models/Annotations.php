<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotations extends Model
{
    protected $fillable = [
      'image_path',
      'feedback',
      'created_by',
      'order_id',
      'preview_number',
    ];
}
