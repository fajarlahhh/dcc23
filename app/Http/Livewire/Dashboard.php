<?php

namespace App\Http\Livewire;

use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $network;

    public function booted()
    {
        $this->network = UserView::with('downline.downline.downline')->with('invalidLeft')->with('invalidRight')->select(
            '*',
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right')
        )->where('id', auth()->id())->first();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
