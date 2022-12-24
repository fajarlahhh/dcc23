<?php

namespace App\Traits;

/**
 *
 */
trait UserTrait
{
    public static function bootUserTrait()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });
        }
    }
}
