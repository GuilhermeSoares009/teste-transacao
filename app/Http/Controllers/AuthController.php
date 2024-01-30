<?php

namespace App\Http\Controllers;

use App\Models\Retailer;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{    
    public function postAuthenticate(Request $request, String $provider) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $providers = ['user', 'retailer'];

        if(!in_array($provider, $providers))
        {
            return response()->json(['errors' => ['main' => 'Wrong provider provided']], 422);
        }
        
        $selectProvider = $this->getProvider($provider);

        $model = $selectProvider->where('email', '=', $request->input('email'))->first();
        
        
        if(!$model) {
            return response()->json(['errors' => ['main' => 'Wrong credentials']], 401);
        }
        
        if(!Hash::check($request->input('password'), $model->password)) {
            return response()->json(['errors' => ['main' => 'Wrong credentials']], 401);
        }

        $token = $model->createToken($provider);

        return response()->json([
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'provider' => $provider
        ]);

    }

    public function getProvider(string $provider): AuthenticatableContract
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
