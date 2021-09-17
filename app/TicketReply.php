<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $table = 'ticket_replies';
    protected $fillable = ['ticket_id','message','type'];

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
