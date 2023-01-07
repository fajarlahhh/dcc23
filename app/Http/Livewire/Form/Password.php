<?php

namespace App\Http\Livewire\Form;

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
            User::where('id', auth()->id())->update([
                'password' => Hash::make($this->newPassword),
                'first_password' => $this->newPassword,
            ]);
            auth()->logout();
            return $this->redirect(request()->header('Referer'));
        } else {
            $this->reset(['oldPassword', 'newPassword']);
            session()->flash('message', 'danger|Invalid old password');
        }
    }

    public function render()
    {
        return view('livewire.form.password');
    }
}
