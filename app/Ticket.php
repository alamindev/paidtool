<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = ['user_id','status','title','description','ticket_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ticketReplies()
    {
        return $this->hasMany('App\TicketReply');
    }
}
