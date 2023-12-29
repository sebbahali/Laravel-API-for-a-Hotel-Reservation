<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Room extends Model
{
    use HasFactory;

  protected $fillable = [
    'images',
    'adults',
    'children',
    'is_booked',
    'hotel_id',
  ];

 public function hotel() :BelongsTo
{
  return $this->belongsTo(Hotel::class);
}
 
   public function files() :Attribute 
{
 return Attribute::make(

    get: fn ($value, $attributes) => collect(json_decode($attributes['images']))
 );
}
}