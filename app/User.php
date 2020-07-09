<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'theme'
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

    public function activities()
    {
        # User Has Many Activities
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Activity');
    }

    public function budgets()
    {
        # User Has Many Budgets
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Budget');
    }

    public function incomes()
    {
        # User Has Many Incomes
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Income');
    }

    public function roles()
    {
        # User has many roles
        # Define a many-to-many relationship
        return $this->belongsToMany('App\Role')->withTimestamps();
    }
}
