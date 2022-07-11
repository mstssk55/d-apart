<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function roads()
    {
        return $this->hasMany(Road::class);
    }


}
