<?php

namespace App\Http\Livewire\Form;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sendbalance extends Component
{
    public $amount, $username, $pin;

    public function send()
    {
        $this->validate([
            'amount' => 'required|numeric',
            'username' => 'required',
        ]);

        try {
            if (auth()->user()->pin != $this->pin) {
                session()->flash('message', 'danger|Invalid PIN');
            } else {
                $send = true;

                if (User::where('username', $this->username)->count() == 0) {
                    $send = false;
                    session()->flash('message', 'danger|Invalid username');
                }

                if ($this->amount > auth()->user()->balance->sum('amount')) {
                    $send = false;
                    session()->flash('message', 'danger|Insufficient balance');
                }

                if ($send == true) {
                    DB::transaction(function () {
                        $sendFrom = new Balance();
                        $sendFrom->description = "Send to " . $this->username;
                        $sendFrom->amount = -$this->amount;
                        $sendFrom->user_id = auth()->id();
                        $sendFrom->save();

                        $sendFrom = new Balance();
                        $sendFrom->description = "Received from " . auth()->user()->username;
                        $sendFrom->amount = $this->amount;
                        $sendFrom->user_id = User::where('username', $this->username)->first()->getKey();
                        $sendFrom->save();
                        return $this->redirect(request()->header('Referer'));
                    });
                }
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }
    public function render()
    {
        return view('livewire.form.sendbalance');
    }
}
