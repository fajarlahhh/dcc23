<?php

namespace App\Http\Livewire;

use App\Models\Bonus;
use App\Models\Deposit;
use App\Models\InvalidTurnover;
use App\Models\User;
use App\Models\UserView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Requestactivation extends Component
{
    use WithPagination;
    public $cari, $activate, $delete, $upline;

    public function setUpline($id, $team)
    {
        $downline = User::where('upline_id', $id)->where('team', $team)->get();
        if ($downline->count() > 0) {
            $this->setUpline($downline->first()->getKey(), $team);
        } else {
            $this->upline = User::find($id);
        }
    }

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
            $bonus = [];
            $dataInvalid = [];
            $parentLength = 0;

            $deposit = Deposit::findOrFail($this->activate);
            $deposit->processed_at = now();
            $deposit->save();

            $user = User::findOrFail($deposit->user_id);

            if ($deposit->registration == 2) {
                $user->reinvest = $user->reinvest + 1;

                $currentBonus = round($user->bonus->sum('amount') / 2);

                Bonus::where('user_id', $deposit->user_id)->whereNull('invalid')->delete();

                $bonus[] = [
                    'description' => 'Remaining 50% bonus from ' . number_format($user->bonus->sum('amount')),
                    'amount' => $currentBonus,
                    'user_id' => $deposit->user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                $this->setUpline($user->sponsor_id, $user->team);
                $user->network = $this->upline ? $this->upline->network . $this->upline->getKey() . $user->team : $user->sponsor->network . $user->sponsor_id . $user->team;
                $user->reinvest = 1;
                $user->upline_id = $this->upline ? $this->upline->getKey() : $user->sponsor_id;
            }
            $user->activated_at = now();
            $user->processed_at = now();
            $user->save();

            $idParent = str_replace(['r', 'l'], [';', ';'], $user->network);
            $dataParent = UserView::with('invalidLeft')->with('invalidRight')->select(
                '*',
                DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
                DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right')
            )->with('package')->whereIn('id', explode(';', $idParent))->orderBy('id', 'desc')->get()->map(function ($q) {
                $validLeft = (int) $q->valid_left - $q->invalidLeft->sum('amount');
                $validRight = (int) $q->valid_right - $q->invalidRight->sum('amount');

                return [
                    'id' => $q->id,
                    'username' => $q->username,
                    'upline_id' => $q->upline_id,
                    'network' => $q->network,
                    'package' => $q->package_value,
                    'position' => $q->network ? substr($q->network, -1) : null,
                    'pair' => $validLeft > 0 && $validRight > 0 ? 1 : 0,
                    'valid_left' => $validLeft,
                    'valid_right' => $validRight,
                    "activated_at" => $q->activated_at,
                    'deleted_at' => $q->deleted_at,
                ];
            });

            if ($user->sponsor_id) {
                $bonus[] = [
                    'description' => 'Sponsor ' . $user->package->sponsorship_benefits . ' of ' . $user->package->value . ' (' . $user->username . ')',
                    'amount' => $user->package->sponsorship_benefits,
                    'user_id' => $user->sponsor_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

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
                    array_push($dataInvalid, [
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

            $invalidData = collect($dataInvalid)->chunk(400);

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
        $deposit = Deposit::findOrFail($this->delete);
        if ($deposit->registration == 1) {
            User::whereId($deposit->user_id)->delete();
        } else if ($deposit->registration == 2) {
            Deposit::withId($this->delete);
        }

        $this->delete = null;
    }

    public function render()
    {
        return view('livewire.requestactivation', [
            'i' => ($this->page - 1) * 10,
            'data' => Deposit::with('user')->whereNotNull('registration')->whereNull('processed_at')->orderBy('created_at')->paginate(10),
        ]);
    }
}
