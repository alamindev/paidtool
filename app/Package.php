<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = ['package_id','package_price','work_type','contract_period','payment_task','total_task', 'payment_status','com','tcom'];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    public function counttasks()
    {
        return $this->hasOne('App\Task');
    }

    public function assignedTasks()
    {
        return $this->hasMany('App\AssignedTask');
    }

    public function taskReplies()
    {
        return $this->hasMany('App\TaskReply');
    }


    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot(["id", "invoice_id", "address", "is_activated", "created_at", "updated_at"]);
    }
}
