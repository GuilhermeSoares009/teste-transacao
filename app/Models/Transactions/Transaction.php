<?php

namespace App\Models\Transactions;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;

    protected $table = 'wallet_transactions';

    protected $fiillable = ['id', 'payee_id', 'payer_id', 'amount'];

    public function wallet() 
    {   
        return $this->belongsTo(Wallet::class);
    }
}
