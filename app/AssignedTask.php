<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedTask extends Model
{
    protected $fillable = ['user_id','package_id','task_id','is_replied','is_send','is_accepted'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}