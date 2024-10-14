<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Location;

class Tour extends Model
{
    use HasFactory;
    //protected $perPage = 3;
    protected $table = "tours";
    protected $fillable = ["name", "price", "duration", "difficulty", "imageCover", "maxGroupSize", "summary", "description", "guide_id"];

    public function images()
    {
        return $this->hasMany(TourImage::class, 'tour_id', 'id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'tour_id', 'id');
    }
}
