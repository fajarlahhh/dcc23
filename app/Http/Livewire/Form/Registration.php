<?php

namespace App\Http\Livewire\Form;

use App\Models\Balance;
use App\Models\Bonus;
use App\Models\InvalidTurnover;
use App\Models\Package;
use App\Models\User;
use App\Models\UserView;
use App\Rules\PinRule;
use App\Rules\UsernameRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Registration extends Component
{
    public $upline, $pin, $username, $name, $team = 'l', $password, $package, $email, $phone;

    public function setUpline($id, $team)
    {
        $downline = User::where('upline_id', $id)->where('team', $team)->get();
        if ($downline->count() > 0) {
            $this->setUpline($downline->first()->getKey(), $team);
        } else {
            $this->upline = User::find($id);
        }
    }

    public function submit()
    {
        $this->validate([
            'username' => ['required', 'regex:/^\S*$/u', new UsernameRule()],
            'pin' => ['required', 'numeric', new PinRule()],
            'team' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'package' => 'required|numeric|max:' . auth()->user()->balance->sum('amount'),
        ]);

        try {
            DB::transaction(function () {
                $this->setUpline(auth()->id(), $this->team);

                $user = new User();
                $user->username = $this->username;
                $user->password = Hash::make($this->username);
                $user->first_password = $this->username;
                $user->name = $this->name;
                $user->email = $this->email;
                $user->team = $this->team;
                $user->network = $this->upline ? $this->upline->network . $this->upline->getKey() . $this->team : auth()->user()->network . auth()->id() . $this->team;
                $user->phone = $this->phone;
                $user->reinvest = 1;
                $user->upline_id = $this->upline ? $this->upline->getKey() : auth()->id();
                $user->sponsor_id = auth()->id();
                $user->package_id = Package::where('value', $this->package)->first()->getKey();
                $user->activated_at = now();
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

                $balance = new Balance();
                $balance->description = 'Registration ' . $this->package . ' (' . $this->username . ')';
                $balance->amount = -$this->package;
                $balance->user_id = auth()->id();
                $balance->save();

                $bonus = [];
                $invalid = [];
                $parentLength = 0;

                $bonus[] = [
                    'description' => 'Sponsor ' . $user->package->sponsorship_benefits . ' of ' . $this->package . ' (' . $this->username . ')',
                    'amount' => $user->package->sponsorship_benefits,
                    'user_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $network = $user->network;
                foreach ($dataParent as $key => $row) {
                    if (is_null($row['deleted_at']) && !is_null($row['activated_at'])) {
                        if ($row['pair'] == 1) {
                            if (substr($network, -1) == 'l') {
                                if ($row['valid_left'] - $this->package < $row['valid_right']) {
                                    $reward = 0;
                                    if ($row['valid_left'] > $row['valid_right']) {
                                        $reward = $row['valid_right'] - $row['valid_left'] + $this->package;
                                    } else {
                                        $reward = $this->package;
                                    }
                                    array_push($bonus, [
                                        'description' => "Left Pairing 10% of " . number_format($reward, 2) . " by " . $this->username,
                                        'amount' => $reward * 10 / 100,
                                        'user_id' => $row['id'],
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                }
                            } elseif (substr($network, -1) == 'r') {
                                if ($row['valid_right'] - $this->package < $row['valid_left']) {
                                    $reward = 0;
                                    if ($row['valid_right'] > $row['valid_left']) {
                                        $reward = $row['valid_left'] - $row['valid_right'] + $this->package;
                                    } else {
                                        $reward = $this->package;
                                    }
                                    array_push($bonus, [
                                        'description' => "Right Pairing 10% of " . number_format($reward, 2) . " by " . $this->username,
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
                            'amount' => $this->package,
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
                session()->flash('message', 'success|Registration ' . $this->username . ' succesfully');
                return $this->redirect(request()->header('Referer'));
            });
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.form.registration');
    }
}
