<?php

namespace App\Models\Transactions;

use App\Models\Transactions\Transaction;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Wallet extends Model
{
    public $incrementing = false;
    
    protected $fillable = ['id', 'user_id','balance'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
    
}
