<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use Livewire\Component;

class Createpin extends Component
{
    public $pin;

    public function submit()
    {
        $this->validate(
            [
                'pin' => 'required|numeric',
            ]
        );
        User::find(auth()->id())->update([
            'pin' => $this->pin,
        ]);
        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.form.createpin');
    }
}
