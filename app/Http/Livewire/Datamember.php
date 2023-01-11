<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Datamember extends Component
{
    use WithPagination;
    public $search, $reset, $delete, $restore, $exist = 1, $activeDate, $active = 1;
    protected $queryString = ['search', 'exist'];

    public function setReset($reset = null)
    {
        $this->reset = $reset;
    }

    public function setDelete($delete = null)
    {
        $this->delete = $delete;
    }

    public function setRestore($restore = null)
    {
        $this->restore = $restore;
    }

    public function resetPassword()
    {
        User::where('id', $this->reset)->update([
            'password' => Hash::make(User::findOrFail($this->reset)->username),
        ]);
        $this->reset = null;
    }

    public function delete()
    {
        User::where('id', $this->delete)->update([
            'deleted_at' => now(),
        ]);
        $this->delete = null;
    }

    public function restore()
    {
        User::where('id', $this->restore)->update([
            'deleted_at' => null,
        ]);
        $this->restore = null;
    }

    public function updatedActive()
    {
        if ($this->active == 1) {
            $this->activeDate = null;
        }
    }

    public function render()
    {
        return view('livewire.datamember', [
            'i' => ($this->page - 1) * 10,
            'data' => UserView::with('upline')->with('sponsor')->with('invalidLeft')->with('invalidRight')->when($this->exist == 2, fn($q) => $q->whereNotNull('deleted_at'))->when($this->exist == 1, fn($q) => $q->whereNull('deleted_at'))->select(
                '*',
                DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.id, "l")))=concat(user_view.id, "l") ) valid_left'),
                DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.id, "r")))=concat(user_view.id, "r") ) valid_right')
            )->when($this->active == 2, fn($q) => $q->where('activated_at', 'like', $this->activeDate . '%'))->whereNotNull('upline_id')->where('username', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }
}
