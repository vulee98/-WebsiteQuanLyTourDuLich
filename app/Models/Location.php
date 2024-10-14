<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    // protected $perPage = 3;
    protected $table = "locations";
    protected $fillable = ["longtitude", "latitude", "description", "day", "tour_id"];
    //protected $guarded = [];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }
}
