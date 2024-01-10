<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users() :HasMany
    {
        return  $this->hasmany(User::class);
    }
    public function hasRoles(array $roles) :bool
     {
        return in_array($this->role->name, $roles);
     }
}
