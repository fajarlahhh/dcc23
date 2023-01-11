<?php

namespace App\Http\Livewire;

use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Downline extends Component
{
    public $key, $username;

    protected $queryString = ['key', 'username'];

    public function mount()
    {
        $this->key = $this->key ?: auth()->id();
    }

    public function render()
    {
        $network = UserView::with('downline.downline.downline')->with('invalidLeft')->with('invalidRight')->select(
            '*',
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right')
        );

        if ($this->username) {
            $network = $network->where('username', $this->username)->first();
        } else {
            $network = $network->where('id', $this->key)->first();
        };
        return view('livewire.downline', [
            'network' => $network,
        ]);
    }
}
