<?php

namespace App\Repositories;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\InvalidDataProviderException;

class AuthRepository 
{    

    public function authenticate(string $provider, array $fields): array 
    {
        
        $providers = ['user', 'retailer'];

        if(!in_array($provider, $providers))
        {
            throw new InvalidDataProviderException("Wrong provider provided",422);
        }
        
        $selectedProvider = $this->getProvider($provider);
        $model = $selectedProvider->where('email', '=', $fields['email'])->first();
        
        
        if(!$model) {
            throw new AuthorizationException("Wrong credentials", 401);
        }
        
        if(!Hash::check($fields['password'], $model->password)) {
            // return response()->json(['errors' => ['main' => 'Wrong credentials']]);
            throw new AuthorizationException("Wrong credentials", 401);
        }

        $token = $model->createToken($provider);

        return [
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'provider' => $provider
        ];
    }

    public function getProvider(string $provider)
    {

        if($provider == "user") {
            return new User();
        } else if ($provider == "retailer") {
            return new Retailer();
        } else {
            throw new \Exception('Provider Not found');
        }
    }

}
