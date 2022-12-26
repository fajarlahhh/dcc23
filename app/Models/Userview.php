<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Userview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_view';

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function downline()
    {
        return $this->hasMany(Userview::class, 'upline_id')->with('invalidLeft')->with('invalidRight')->select(
            '*',
            DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "l;")))=concat(user_view.network, user_view.id, "l;") ) valid_left'),
            DB::raw('(select ifnull(sum(package * reinvest), 0) from user_view uv where uv.activated_at is not null and left(uv.network, length(concat(user_view.network, user_view.id, "r;")))=concat(user_view.network, user_view.id, "r;") ) valid_right'),
        );
    }

    public function invalidRight()
    {
        return $this->hasMany(Invalidturnover::class, 'user_id')->where("team", "r;");
    }

    public function invalidLeft()
    {
        return $this->hasMany(Invalidturnover::class, 'user_id')->where("team", "l;");
    }
}
