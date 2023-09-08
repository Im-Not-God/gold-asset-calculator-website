<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'type',
        'price',
        'detail',
        'updated_at',
    ];
}
