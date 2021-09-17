<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddPackage extends Model
{
    protected $table = 'package_user';
    protected $user_id = ['user_id'];
    protected $package_id = ['package_id'];
    protected $is_activated = ['is_activated'];

    public function package()
    {
        return $this->belongsTo('App\AddPackage');
    }
}
