<?php

namespace App\Http\Livewire;

use App\Models\Deposit;
use App\Models\User;
use App\Traits\MasteruserTrait;
use Livewire\Component;

class Activation extends Component
{
    use MasteruserTrait;

    public $fromWallet, $txid;

    public function submit()
    {
        $this->validate(['fromWallet' => 'required', 'txid' => 'required']);

        $deposit = new Deposit();
        $deposit->from_wallet = $this->fromWallet;
        $deposit->txid = $this->txid;
        $deposit->to_wallet = $this->masterUser->wallet;
        $deposit->amount = auth()->user()->package->value;
        $deposit->registration = 1;
        $deposit->save();

        return $this->redirect(request()->header('Referer'));
    }

    public function cancel($id)
    {
        User::where('id', $id)->delete();
        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.activation')->extends('layouts.activation');
    }
}
