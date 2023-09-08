<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'num_of_transactions',
    ];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'portfolio_transaction');
    }
}
