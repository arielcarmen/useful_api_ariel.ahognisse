<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletTopupRequest;
use App\Http\Requests\WalletTransfertRequest;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->get()->map->only(['id', 'sender_id', 'receiver_id', 'amount', 'status', 'created_at']);

        return response($transactions, 200);
    }

    public function wallet()
    {
        $wallet = Auth::user()->wallet;

        return response(['user_id' => Auth::id(), 'balance' => $wallet->balance]);
    }

    public function transfert(WalletTransfertRequest $request)
    {
        $request->validated();

        if ($request->receiver_id === Auth::id()) {
            return response(['message' => 'Auto tranfert forbidden'], 400);
        }

        if (Auth::user()->wallet->balance < $request->amount) {
            return response(['message' => 'Insufficient balance'], 403);
        }

        $receiverWallet = Wallet::where('user_id', $request->receiver_id)->first();

        $transaction = Transaction::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'status' => 'success',
        ]);

        if (!Auth::user()->wallet || !$receiverWallet) {
            $transaction->status = "failed";
        } else {
            Auth::user()->wallet->decrement('balance', $request->amount);
            $receiverWallet->increment('balance', $request->amount);
        }

        $data = [
            'transaction_id' => $transaction->id,
            'sender_id' => $transaction->sender_id,
            'receiver_id' => $transaction->receiver_id,
            'amount' => $transaction->amount,
            'status' => $transaction->status,
            'created_at' => $transaction->created_at,
        ];

        return response($data, 201);
    }

    public function topup(WalletTopupRequest $request){
        if ($request->amount > 10000) {
            return response(['message' => 'You can\'t topup more than 10000'], 400);
        }

        $topup = Topup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);

        $wallet = Auth::user()->wallet;
        $wallet->increment('balance', $request->amount);

        $data = [
            'user_id' => $topup->user_id,
            'balance' => $wallet->balance,
            'topup_amount' => $topup->amount,
            'created_at' => $topup->created_at,
        ];

        return response($data, 201);
    }
}
