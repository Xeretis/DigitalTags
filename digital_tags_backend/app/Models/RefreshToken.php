<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    protected $casts = [
        'abilities' => 'json',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'token',
        'abilities',
        'expires_at',
    ];

    protected $hidden = [
        'token',
    ];

    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }

    public function parent()
    {
        return $this->belongsTo(RefreshToken::class);
    }
}
