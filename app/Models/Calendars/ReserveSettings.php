<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;


class ReserveSettings extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'setting_reserve',
        'setting_part',
        'limit_users',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_reserve_settings', 'reserve_setting_id', 'user_id');
    }
}
