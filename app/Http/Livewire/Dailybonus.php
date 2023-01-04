<?php

namespace App\Http\Livewire;

use App\Models\Bonus;
use App\Models\Daily;
use App\Models\User;
use App\Models\UserView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dailybonus extends Component
{
    public $daily = [], $delete;

    public function submit()
    {
        $this->validate([
            'daily' => 'required',
            'daily.*.date' => 'required',
            'daily.*.bonus' => 'required|numeric',
        ]);

        DB::transaction(function () {
            foreach ($this->daily as $key => $row) {
                $daily = new Daily();
                $daily->date = $row['date'];
                $daily->amount = $row['bonus'];
                $daily->save();

                $bonus = [];
                foreach (UserView::whereRaw("date(created_at) <= '" . $row['date'] . "'")->whereNull('deleted_at')->whereNotNull('activated_at')->get() as $subRow) {
                    array_push($bonus, [
                        'description' => "Daily bonus " . $row['date'] . " " . $row['bonus'] . " %",
                        'amount' => $subRow->package * $row['bonus'] / 100,
                        'daily_id' => $daily->id,
                        'user_id' => $subRow->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                if ($bonus) {
                    $dataBonus = collect($bonus)->chunk(1000);
                    foreach ($dataBonus as $subRow) {
                        Bonus::insert($subRow->toArray());
                    }
                }
            }
        });
        $this->daily = [];
    }

    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

    public function delete()
    {
        $data = Daily::find($this->delete);
        Bonus::where('daily_id', $data->id)->delete();
        $data->delete();
        $this->booted();
    }

    public function booted()
    {
        $this->daily = [];
        $data = Daily::orderBy('date', 'desc')->get();
        if ($data->count() == 0) {
            $last = date('Y-m-d', strtotime(User::whereNotNull('upline_id')->orderBy('id', 'desc')->first()->created_at));
        } else {
            $last = Carbon::parse($data->first()->date)->format('Y-m-d');
        }
        $from = Carbon::parse($last);
        $now = Carbon::now();

        $this->diff = $from->diffInDays($now) + 1;
        for ($i = 0; $i < $this->diff; $i++) {
            $this->daily[] = [
                'date' => Carbon::parse($last)->addDays($i + 1)->format('Y-m-d'),
                'bonus' => null,
            ];
        }
    }

    public function render()
    {
        return view('livewire.dailybonus', [
            'data' => Daily::orderBy('created_at', 'desc')->limit(10)->get(),
        ]);
    }
}
