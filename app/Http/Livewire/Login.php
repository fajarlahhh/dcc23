<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $remember = false, $username, $password;

    public function submit()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            Auth::logoutOtherDevices($this->password);
            return redirect('/dashboard');
        } else {
            session()->flash('message', 'danger|Invalid credential');
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
