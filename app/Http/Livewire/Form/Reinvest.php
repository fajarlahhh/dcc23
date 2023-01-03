<?php

namespace App\Http\Livewire\Form;

use App\Models\Deposit;
use App\Models\User;
use App\Traits\MasteruserTrait;
use Livewire\Component;

class Reinvest extends Component
{
    use MasteruserTrait;
    public $fromWallet;

    public function submit()
    {
        $this->validate(['fromWallet' => 'required']);

        $deposit = new Deposit();
        $deposit->to_wallet = $this->masterUser->wallet;
        $deposit->from_wallet = $this->fromWallet;
        $deposit->amount = auth()->user()->package->value;
        $deposit->reinvest = 1;
        $deposit->save();
        return $this->redirect('/activation');
    }

    public function render()
    {
        return view('livewire.form.reinvest');
    }
}
