<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Activation extends Component
{
    public $fromWallet;

    public function submit()
    {
        $this->validate(['fromWallet' => 'required']);

        User::where('id', auth()->id())->update([
            'from_wallet' => $this->fromWallet,
        ]);
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
