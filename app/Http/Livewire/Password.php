<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $oldPassword, $newPassword;

    public function submit()
    {
        $this->validate(
            [
                'oldPassword' => 'required',
                'newPassword' => 'required',
            ]
        );

        if (Hash::check($this->oldPassword, auth()->user()->password)) {
            User::find(auth()->id())->update([
                'password' => Hash::make($this->newPassword),
            ]);
            session()->flash('message', 'success|Password updated succesfully');
        } else {
            session()->flash('message', 'danger|Invalid old password');
        }
        $this->reset(['oldPassword', 'newPassword']);
    }

    public function render()
    {
        return view('livewire.password');
    }
}
