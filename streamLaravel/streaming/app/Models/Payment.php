<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    protected $collection = 'payments';

    protected $fillable = [
        'name', 'product', 'price', 'subject', 'email_id', 'payment_type','random_text'
    ];
}
