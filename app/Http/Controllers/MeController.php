<?php

namespace App\Http\Controllers;

class MeController extends Controller 
{
 
    public function __construct() {
        $this->middleware('auth:retailer');
        $this->middleware('auth:users');
    }

    public function getMe()
    {
        
    }
}