<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $fillable = ['tour_id', 'user_id', 'tourName', 'userName', 'phoneNumber', 'approved', 'price'];
}
