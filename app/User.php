<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref','name', 'email', 'password', 'phone', 'address', 'country', 'balance', 'min_withdrawl', 'commission','refcommission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function packages()
    {
        return $this->belongsToMany('App\Package')->withPivot(["id", "invoice_id", "address", "is_activated", "created_at", "updated_at", "payment_status"]);
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    
    public function assignedTask()
    {
        return $this->belongsToMany(Task::class, "assigned_tasks")->withPivot('is_replied','is_accepted');
    }

    public function taskReplies()
    {
        return $this->hasMany('App\TaskReply');
    }

    public function isAdmin()
    {
        return ($this->role_id == 1) ? true : false;
    }

    public function btc_detail()
    {
        return $this->hasOne(BtcDetail::class);
    }

    public function withdrawls()
    {
        return $this->hasMany(Withdrawl::class);
    }
}