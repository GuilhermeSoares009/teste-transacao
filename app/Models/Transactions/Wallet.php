<?php

namespace App\Models;

use App\Models\Transactions\Transaction;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $incrementing = false;
    
    protected $fillable = ['id', 'user_id'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
