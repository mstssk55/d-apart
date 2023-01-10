<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $dates = [
        'open_date',
        'start_date',
        'structure_start_date',
        'structure_end_date',
        'debt_start_date',
        'debt_end_date',
        'created_at',
        'updated_at'
    ];
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

    public function floors()
    {
      return $this->hasMany(Floor::class);
    }

    public function others()
    {
      return $this->hasMany(Other::class);
    }
    public function bikous()
    {
      return $this->hasMany(Bikou::class);
    }
    public static function bikous_kind($kind,$project_id)
    {
        return Bikou::query()
        ->where([
            ['project_id', '=', $project_id],
            ['kind', '=', $kind]
        ])
        ->get();
    }







}
