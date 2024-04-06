<?php

namespace App\Repositories\Transaction;

use App\Exceptions\NoMoreMoneyException;
use App\Exceptions\TransactionDeniedException as TransactionDeniedException;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        if(!$this->checkUserBalance($user,$data['amount'])){
            throw new NoMoreMoneyException("you don't have money");
        }

        return [];
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

    private function checkUserBalance($user, $money)
    {
        return $user->wallet->ballance >= $money;
    
    }
}
