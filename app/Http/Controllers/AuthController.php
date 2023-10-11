<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function postAuthenticate(String $provider) {
        return 'texto'.$provider;
    }
}
