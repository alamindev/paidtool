<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckPackage extends Model
{
    protected $table = 'package_user';
    protected $user_id = ['user_id'];

    public function package()
    {
        return $this->belongsTo('App\AddPackage');
    }
}
