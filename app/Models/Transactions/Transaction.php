<?php

namespace App\Models\Transactions;

use App\Models\Transactions\Wallet as Wallet;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;

    protected $table = 'wallet_transactions';

    protected $fiillable = ['id', 'payee_wallet_id', 'payer_wallet_id', 'amount'];

    public function walletPayer() 
    {   
        return $this->belongsTo(Wallet::class, 'id','payer_wallet_id');
    }

    public function walletPayee() 
    {   
        return $this->belongsTo(Wallet::class, 'id','payee_wallet_id');
    }
}
