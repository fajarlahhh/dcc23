<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use App\Rules\PinRule;
use Livewire\Component;

class Pin extends Component
{
    public $oldPin, $newPin;

    public function submit()
    {
        $this->validate(
            [
                'oldPin' => ['required', new PinRule()],
                'newPin' => 'required',
            ]
        );

        User::find(auth()->id())->update([
            'pin' => $this->newPin,
        ]);
        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.form.pin');
    }
}
