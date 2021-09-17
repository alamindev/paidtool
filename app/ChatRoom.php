<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function replies()
    {
        return $this->hasMany(ChatRoom::class, 'parent_id')->with('user');
    }
}