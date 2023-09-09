<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'type',
        'downpayment',
        'gold_price',
        'convert_percent',
        'management_fee_percent',
        'created_at'
    ];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }
}
