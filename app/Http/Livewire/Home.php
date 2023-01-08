<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $sponsor = 'mark', $team = 'l';

    public function mount($sponsor = null, $team = null)
    {
        $this->sponsor = $sponsor ?: 'mark';
        $this->team = $team ?: 'l';
    }

    public function render()
    {
        return view('livewire.home')->extends('layouts.home');
    }
}
