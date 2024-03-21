<?php

namespace App\Repositories\Transaction;

use App\Models\Retailer;
use App\Models\User;
use PHPUnit\Framework\InvalidDataProviderException;

class TransactionRepository 
{
    public function handle(array $data): array
    {
        $model = $this->getProvider($data['provider']);

        $user = $model->findOrFail($data['payee_id']);

        return [];
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
