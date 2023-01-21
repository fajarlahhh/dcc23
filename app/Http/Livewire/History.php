<?php

namespace App\Http\Livewire;

use App\Models\Bonus;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public $tipe = 'daily', $year, $month;
    protected $queryString = ['tipe', 'year', 'month'];

    public function mount()
    {
        $this->year = $this->year ?: date('Y');
        $this->month = $this->month ?: date('m');
    }

    public function render()
    {
        switch ($this->tipe) {
            case 'daily':
                $data = Bonus::whereNotNull('daily_id')->where('user_id', auth()->id());
                break;
            case 'pairing':
                $data = Bonus::whereNull('daily_id')->where('description', 'like', '%Pairing%')->where('user_id', auth()->id());
                break;
            case 'sponsor':
                $data = Bonus::whereNull('daily_id')->where('description', 'like', 'Sponsor%')->where('user_id', auth()->id());
                break;

            default:
                $data = Bonus::whereNotNull('daily_id')->where('user_id', auth()->id());
                break;
        }

        return view('livewire.history', [
            'i' => ($this->page - 1) * 10,
            'data' => $data->where('created_at', 'like', $this->year . '-' . $this->month . '%')->paginate(10),
        ]);
    }
}
