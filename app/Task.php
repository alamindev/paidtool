<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = ['title','description','is_sent','package_id','type','url'];
    
    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function taskReplies()
    {
        return $this->hasMany('App\TaskReply');
    }
    
    public function assignedTasks()
    {
        return $this->hasMany(AssignedTask::class);
    }

    public function assignedTasksReplied()
    {
        return $this->hasMany(AssignedTask::class)->where("is_accepted", "!=", 1);
    }

    public function assignedTasksAccepted()
    {
        return $this->hasMany(AssignedTask::class)->where("is_accepted", 1);
    }

    public function getAcceptedAttribute()
    {
        return ($this->assignedTasks()->where("is_accepted", 1)->exists()) ? 1 : 0;
    }
    
    public function getRepliesCountAttribute()
    {
        return $this->taskReplies()->count();
    }
}
