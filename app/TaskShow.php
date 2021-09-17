<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskShow extends Model
{

    protected $fillable = ['title','description','is_sent','package_id'];

    
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
