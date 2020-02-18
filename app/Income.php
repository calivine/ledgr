<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public function user()
    {
        # Income Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }
}
