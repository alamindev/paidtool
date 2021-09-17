<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskReply extends Model
{
    protected $table = 'task_replies';
    
    protected $fillable = ['user_id','task_id','task_reply', 'task_attachment'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function task()
    {
        return $this->belongsTo('App\Task');
    }
   
}
