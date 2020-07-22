<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function activities()
    {
        # Bill Has Many Activities
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Activity');
    }

    public function user()
    {
        # Bill Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }
}
