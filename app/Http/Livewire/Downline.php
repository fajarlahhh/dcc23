<?php

namespace App\Http\Livewire;

use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Downline extends Component
{
    public $network, $key;

    protected $queryString = ['key'];

    public function mount()
    {
        $this->key = $this->key ?: auth()->id();
    }

    public function booted()
    {
        $this->network = UserView::with('downline.downline.downline')->with('invalidLeft')->with('invalidRight')->select(
            '*',
            DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
            DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right')
        )->where('id', $this->key)->first();
    }

    public function render()
    {
        return view('livewire.downline');
    }
}
