<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountTask extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['title','description','is_sent','package_id'];

    protected $appends = ["accepted", "replies_count"];
    
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
