<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use Livewire\Component;

class Createwallet extends Component
{
    public $wallet;

    public function submit()
    {
        $this->validate(
            [
                'wallet' => 'required',
            ]
        );
        User::find(auth()->id())->update([
            'wallet' => $this->wallet,
        ]);
        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.form.createwallet');
    }
}
