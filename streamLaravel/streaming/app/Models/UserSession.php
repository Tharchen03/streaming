<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_sessions';

    protected $fillable = [
        'session_id', 'payment_id', 'ip_address', 'user_agent', 'session_key', 'session_value'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}


