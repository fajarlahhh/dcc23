<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Pin extends Component
{
    public $oldPin, $newPin;

    public function submit()
    {
        $this->validate(
            [
                'oldPin' => 'required',
                'newPin' => 'required',
            ]
        );

        if ($this->oldPin == auth()->user()->pin) {
            User::find(auth()->id())->update([
                'pin' => $this->newPin,
            ]);
            session()->flash('message', 'success|PIN updated succesfully');
        } else {
            session()->flash('message', 'danger|Invalid old PIN');
        }
        $this->reset(['oldPin', 'newPin']);
    }

    public function render()
    {
        return view('livewire.pin');
    }
}
