<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function property()
    {
      return $this->belongsTo(Property::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }


    public function plans()
    {
      return $this->hasMany(Plan::class);
    }

    public function parkings()
    {
      return $this->hasMany(Parking::class);
    }

    public function rooms()
    {
      return $this->hasMany(Room::class);
    }
    public function parks()
    {
      return $this->hasMany(Park::class);
    }





}
