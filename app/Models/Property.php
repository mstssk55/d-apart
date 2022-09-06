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
    public function projects()
    {
      return $this->hasMany(Project::class);
    }
    public static function project_list_desc($property_id)
    {
        return Project::query()
        ->where([
            ['property_id', '=', $property_id],
        ])
        ->orderBy('updated_at', 'DESC')
        ->get();
    }


}
