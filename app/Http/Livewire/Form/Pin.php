<?php

namespace App\Http\Livewire\Form;

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
            return $this->redirect(request()->header('Referer'));
        } else {
            $this->reset(['oldPin', 'newPin']);
            session()->flash('message', 'danger|Invalid old PIN');
        }
    }

    public function render()
    {
        return view('livewire.form.pin');
    }
}
