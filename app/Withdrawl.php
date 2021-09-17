<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawl extends Model
{
    protected $fillable = ["user_id", "amount", "btc_address", "flag"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}