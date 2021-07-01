<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    public function user()
    {
        # Pending Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }
}
