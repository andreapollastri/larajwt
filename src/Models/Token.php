<?php

namespace Andr3a\Larajwt\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'user_id',
        'last_activity',
        'payload',
    ];
}
