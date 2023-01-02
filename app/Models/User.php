<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'wallet',
        'pin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function downline()
    {
        return $this->hasMany(User::class, 'upline_id');
    }

    public function balance()
    {
        return $this->hasmany(Balance::class)->orderBy('created_at', 'desc');
    }

    public function bonus()
    {
        return $this->hasmany(Bonus::class)->orderBy('created_at', 'desc');
    }

    public function availablePackage()
    {
        return $this->package()->first()->benefit - $this->bonus()->where('amount', '>', 0)->sum('amount');
    }

    public function withdrawal()
    {
        return $this->hasmany(Withdrawal::class)->orderBy('created_at', 'desc');
    }

    public function deposit()
    {
        return $this->hasMany(Deposit::class)->whereNotNull('from_wallet')->orderBy('created_at', 'desc');
    }

    public function waitingTransferDeposit()
    {
        return $this->hasOne(Deposit::class)->whereNull('from_wallet');
    }

    public function waitingProcessDeposit()
    {
        return $this->hasMany(Deposit::class)->whereNotNull('from_wallet')->whereNull('processed_at');
    }

    public function scopeDownline($query)
    {
        return $query->where('network', 'like', auth()->id() . '%')->orderBy('username', 'asc');
    }

    public function invalidRight()
    {
        return $this->hasMany(InvalidTurnover::class)->where("team", "r");
    }

    public function invalidLeft()
    {
        return $this->hasMany(InvalidTurnover::class)->where("team", "l");
    }
}
