<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BtcDetail extends Model
{
    protected $fillable = ["user_id", "pub_key", "api_key"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
