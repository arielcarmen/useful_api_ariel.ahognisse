<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function wallet(){
        $wallet = Auth::user()->wallet;

        return response(['user_id' => Auth::id(), 'balance'=> $wallet->balance]);
    }
}
