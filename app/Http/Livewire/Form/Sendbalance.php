<?php

namespace App\Http\Livewire\Form;

use App\Models\Balance;
use App\Models\User;
use App\Rules\PinRule;
use App\Rules\UsernameRule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sendbalance extends Component
{
    public $amount, $username, $pin;

    public function send()
    {
        $this->validate([
            'amount' => 'required|numeric|max:' . auth()->user()->balance->sum('amount'),
            'username' => ['required', new UsernameRule(true)],
            'pin' => ['required', 'numeric', new PinRule()],
        ]);

        try {
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
