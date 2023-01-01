<?php

namespace App\Models;

use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory, UserTrait;

    protected $table = 'withdrawal';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
