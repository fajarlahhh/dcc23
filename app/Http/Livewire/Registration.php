<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\User;
use App\Rules\UsernameRule;
use App\Traits\MasteruserTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Registration extends Component
{
    use MasteruserTrait;
    public $upline, $team, $username, $name, $password, $package, $email, $phone;

    public function submit()
    {
        $this->validate([
            'username' => ['required', 'regex:/^\S*$/u', new UsernameRule()],
            'team' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'upline' => 'required',
            'password' => 'required',
            'package' => 'required|numeric',
        ]);

        try {
            $sponsor = User::where('username', $this->upline)->firstOrFail();

            $user = new User();
            $user->username = $this->username;
            $user->password = Hash::make($this->password);
            $user->first_password = $this->username;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->team = $this->team;
            $user->sponsor_id = $sponsor->getKey();
            $user->package_id = Package::where('value', $this->package)->first()->getKey();
            $user->save();

            if (Auth::attempt(['username' => $this->username, 'password' => $this->password], true)) {
                Auth::logoutOtherDevices($this->password);
                return redirect('/activation');
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.registration');
    }
}
