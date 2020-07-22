<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function user()
    {
        # Activity Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }

    public function budget()
    {
        # Activity Belongs To Budget
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\Budget');
    }

    public function bill()
    {
        # Activity Belongs To Bill
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\Bill');
    }
    /*
    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }
    */

    public function getDateAttribute($value)
    {
        return date_to_string($value);
    }

}
