<?php

namespace Castcast;


use Castcast\Entities\Learning;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Redis;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, Learning, Billable, HasApiTokens;

    protected $with = ['subscriptions'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','confirm_token'
    ];

    /**
     * Checks if user's email has been confirmed
     *
     * @return boolean
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    /**
     * Confirm a user's email
     *
     * @return void
     */
    public function confirm() 
    {
        $this->confirm_token = null;
        $this->save();
    }

    public function isAdmin()
    {
        return in_array($this->email, config('castcast.administrators'));
    }

    public function getRouteKeyName(){
        return 'username';
    }

    
}
