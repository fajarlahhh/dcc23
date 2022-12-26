<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use App\Rules\PinRule;
use Livewire\Component;

class Profile extends Component
{
    public $data, $name, $email, $phone, $wallet, $pin;

    public function mount()
    {
        $this->data = User::findOrFail(auth()->id());
        $this->name = $this->data->name;
        $this->email = $this->data->email;
        $this->phone = $this->data->phone;
        $this->wallet = $this->data->wallet;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'wallet' => 'required',
            'pin' => ['required', 'numeric', new PinRule()],
        ]);

        if (auth()->user()->pin != $this->pin) {
            $this->reset(['pin']);
            session()->flash('message', 'danger|Invalid PIN');
        } else {
            $this->data->name = $this->name;
            $this->data->email = $this->email;
            $this->data->phone = $this->phone;
            $this->data->wallet = $this->wallet;
            $this->data->save();
            return $this->redirect(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.form.profile');
    }
}
