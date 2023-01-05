<?php

namespace App\Http\Livewire\Form;

use App\Models\Deposit;
use App\Models\User;
use App\Traits\MasteruserTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reinvest extends Component
{
    use MasteruserTrait;
    public $fromWallet;

    public function submit()
    {
        $this->validate(['fromWallet' => 'required']);

        DB::transaction(function () {
            Deposit::where('user_id', auth()->id())->whereNull('from_wallet')->delete();
            $deposit = new Deposit();
            $deposit->to_wallet = $this->masterUser->wallet;
            $deposit->from_wallet = $this->fromWallet;
            $deposit->amount = auth()->user()->package->value;
            $deposit->registration = 2;
            $deposit->save();
        });
        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.form.reinvest');
    }
}
