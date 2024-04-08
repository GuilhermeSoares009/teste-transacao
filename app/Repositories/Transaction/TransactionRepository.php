<?php

namespace App\Repositories\Transaction;

use App\Exceptions\NoMoreMoneyException;
use App\Exceptions\TransactionDeniedException as TransactionDeniedException;
use App\Models\Retailer;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\InvalidDataProviderException;

class TransactionRepository 
{
    public function handle(array $data): array
    {

        if(!$this->guardCanTransfer()) {
            throw new TransactionDeniedException('Retailer not authorized to make transactions', 401);
        }

        $model = $this->getProvider($data['provider']);

        $user = $model->findOrFail($data['payee_id']);

        if(!$this->checkUserBalance($user->wallet,$data['amount'])){
            throw new NoMoreMoneyException("you don't have money",422);
        }

        return $this->makeTransaction($data);
    }

    public function guardCanTransfer(): bool
    {
        if(Auth::guard('users')->check()) {
            return true;
        } else if (Auth::guard('retailers')->check()) {
            return false;
        } else {
            throw new InvalidDataProviderException('Provider Not found',422);
        }
    }

    public function getProvider(string $provider)
    {

        if($provider == "users") {
            return new User();
        } else if ($provider == "retailers") {
            return new Retailer();
        } else {
            throw new InvalidDataProviderException('Provider Not found',422);
        }
    }

    private function checkUserBalance(Wallet $wallet, $money)
    {
        return $wallet->ballance >= $money;
    
    }

    private function makeTransaction(array $data) {
        $payload = [
            'payer_wallet_id' => Auth::guard($data['provider'])->id,
            'payee_wallet_id' => $data['payee_id'],
            'amount' => $data['amount']
        ];
        return DB::transaction(function () use ($payload) {
            $transaction = Transaction::create($payload);
            $transaction->walletPayer->withdraw($payload['amount']);
            $transaction->walletPayee->deposit($payload['amount']);
        });
    }
}
