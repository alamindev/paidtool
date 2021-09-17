<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packsub extends Model
{
    protected $table = 'package_user';
    protected $fillable = [
        'package_id', 'user_id', 'is_activated', 'invoice_id', 'address', 'payment_status'
    ];
    
}
