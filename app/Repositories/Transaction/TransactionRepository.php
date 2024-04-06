<?php

namespace App\Repositories\Transaction;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\InvalidDataProviderException;

class TransactionRepository 
{
    public function handle(array $data): array
    {
        $model = $this->getProvider($data['provider']);

        $user = $model->findOrFail($data['payee_id']);

        $user->wallet->transaction()->create([

        ]);

        return [];
    }

    public function getGuard()
    {
        if(Auth::guard('users')->check()) {
            return 'user';
        } else if (Auth::guard('retailer')->check()) {
            return 'retailer';
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
}
