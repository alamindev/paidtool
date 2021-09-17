<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddNotice extends Model
{
    protected $table = 'notice';
    protected $title = ['title'];
    protected $fillable = ['description'];

    public function notice()
    {
        return $this->belongsTo('App\AddNotice');
    }
}
