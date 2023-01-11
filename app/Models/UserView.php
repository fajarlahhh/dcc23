<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserView extends Model
{
    use HasFactory;

    protected $table = 'user_view';

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function downline()
    {
        return $this->hasMany(UserView::class, 'upline_id')->with('invalidLeft')->with('invalidRight')->select(
            '*',
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l")))=concat(user_view.network, user_view.id, "l") ) valid_left'),
            DB::raw('(select ifnull(sum(package_value * reinvest), 0) from user_view uv where uv.network is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r")))=concat(user_view.network, user_view.id, "r") ) valid_right'),
        );
    }

    public function invalidRight()
    {
        return $this->hasMany(InvalidTurnover::class, 'user_id')->where("team", "r");
    }

    public function invalidLeft()
    {
        return $this->hasMany(InvalidTurnover::class, 'user_id')->where("team", "l");
    }

    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }
}
