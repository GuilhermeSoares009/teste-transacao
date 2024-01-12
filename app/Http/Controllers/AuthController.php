<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function postAuthenticate(String $provider) {
        $providers = ['user', 'realier'];

        if(!in_array($provider, $providers))
        {
            return response()->json(['errors' => ['main' => 'Wrong provider provided']], 422);
        }

        return 'o provider escolhido foi'. $provider;

    }
}
