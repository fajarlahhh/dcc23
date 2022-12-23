<?php

namespace App\Http\Livewire;

use App\Models\User;
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
            'pin' => 'required',
        ]);

        if (auth()->user()->pin != $this->pin) {
            session()->flash('message', 'danger|Invalid PIN');
        }

        $this->data->name = $this->name;
        $this->data->email = $this->email;
        $this->data->phone = $this->phone;
        $this->data->wallet = $this->wallet;
        $this->data->save();
        session()->flash('message', 'success|Profile updated succesfully');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
