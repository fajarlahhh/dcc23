<?php

namespace App\Http\Livewire;

use App\Models\Bonus;
use App\Models\InvalidTurnover;
use App\Models\User;
use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Requestactivation extends Component
{
    use WithPagination;
    public $cari, $activate, $delete;

    public function setActivate($activate = null)
    {
        $this->activate = $activate;
    }

    public function setDelete($delete = null)
    {
        $this->delete = $delete;
    }

    public function active()
    {
        DB::transaction(function () {
            $user = User::findOrFail($this->activate);
            $upline = User::where('network', 'like', $user->sponsor->network . $user->sponsor_id . $user->team . '%')->orderBy(DB::raw('CHAR_LENGTH(network)'), 'DESC')->first();

            $user->network = $upline->network . $upline->getKey() . $user->team;
            $user->reinvest = 1;
            $user->upline_id = $upline ? $upline->getKey() : 1;
            $user->activated_at = now();
            $user->processed_at = now();
            $user->save();

            $idParent = str_replace(['r', 'l'], [';', ';'], $user->network);
            $dataParent = UserView::with('invalidLeft')->with('invalidRight')->select(
                '*',
                DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
                DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right')
            )->with('package')->whereIn('id', explode(';', $idParent))->orderBy('id', 'desc')->get()->map(function ($q) {
                $validLeft = (int) $q->valid_left - $q->invalidLeft->sum('amount');
                $validRight = (int) $q->valid_right - $q->invalidRight->sum('amount');

                return [
                    'id' => $q->id,
                    'username' => $q->username,
                    'upline_id' => $q->upline_id,
                    'network' => $q->network,
                    'package' => $q->package,
                    'position' => $q->network ? substr($q->network, -1) : null,
                    'pair' => $validLeft > 0 && $validRight > 0 ? 1 : 0,
                    'valid_left' => $validLeft,
                    'valid_right' => $validRight,
                    "activated_at" => $q->activated_at,
                    'deleted_at' => $q->deleted_at,
                ];
            });

            $bonus = [];
            $invalid = [];
            $parentLength = 0;

            $bonus[] = [
                'description' => 'Sponsor ' . $user->package->sponsorship_benefits . ' of ' . $user->package->value . ' (' . $user->username . ')',
                'amount' => $user->package->sponsorship_benefits,
                'user_id' => $user->sponsor_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $network = $user->network;
            foreach ($dataParent as $key => $row) {
                if (is_null($row['deleted_at']) && !is_null($row['activated_at'])) {
                    if ($row['pair'] == 1) {
                        if (substr($network, -1) == 'l') {
                            if ($row['valid_left'] - $user->package->value < $row['valid_right']) {
                                $reward = 0;
                                if ($row['valid_left'] > $row['valid_right']) {
                                    $reward = $row['valid_right'] - $row['valid_left'] + $user->package->value;
                                } else {
                                    $reward = $user->package->value;
                                }
                                array_push($bonus, [
                                    'description' => "Left Pairing 10% of " . number_format($reward, 2) . " by " . $user->username,
                                    'amount' => $reward * 10 / 100,
                                    'user_id' => $row['id'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } elseif (substr($network, -1) == 'r') {
                            if ($row['valid_right'] - $user->package->value < $row['valid_left']) {
                                $reward = 0;
                                if ($row['valid_right'] > $row['valid_left']) {
                                    $reward = $row['valid_left'] - $row['valid_right'] + $user->package->value;
                                } else {
                                    $reward = $user->package->value;
                                }
                                array_push($bonus, [
                                    'description' => "Right Pairing 10% of " . number_format($reward, 2) . " by " . $user->username,
                                    'amount' => $reward * 10 / 100,
                                    'user_id' => $row['id'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }
                }
                if (is_null($row['activated_at'])) {
                    array_push($invalid, [
                        'user_id' => $row['id'],
                        'downline_id' => $user->getKey,
                        'amount' => $user->package->value,
                        'team' => substr($network, -1),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $parentLength = strlen($row['id'] . $row['position']);
                $network = substr($network, 0, (strlen($network) - $parentLength));
            }

            $invalidData = collect($invalid)->chunk(400);

            foreach ($invalidData as $row) {
                InvalidTurnover::insert($row->toArray());
            }
            $bonusData = collect($bonus)->chunk(10);
            foreach ($bonusData as $row) {
                Bonus::insert($row->toArray());
            }
            session()->flash('message', 'success|Activation for ' . $user->username . ' succesfully');
            return $this->redirect(request()->header('Referer'));
        });
    }

    public function delete()
    {
        User::where('id', $this->delete)->update([
            'deleted_at' => now(),
        ]);
        $this->delete = null;
    }

    public function render()
    {
        return view('livewire.requestactivation', [
            'i' => ($this->page - 1) * 10,
            'data' => User::with('sponsor')->whereNull('activated_at')->paginate(10),
        ]);
    }
}
