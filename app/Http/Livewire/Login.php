<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $remember = false, $username, $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            Auth::logoutOtherDevices($this->password, 'password');
            return redirect('/dashboard');
        }
        session()->flash('message', 'danger|Invalid credential');
        return;
    }

    public function render()
    {
        return view('livewire.login');
    }
}
