<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discreption',
        'image',
        'address',
        'user_id'
     
    ];
 
    public function rooms() :HasMany
    {
    return $this->HasMany(Room::class);

    }

    public function user() :BelongsTo
    {

        return $this->belongsTo(user::class);
    }
}
