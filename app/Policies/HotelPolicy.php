<?php

namespace App\Policies;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HotelPolicy
{
   
    public function create(User $user): bool
    {
      
     return $user->role->name == "Admin" || $user->role->name == 'Owner';

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user , Hotel $hotel): bool
    {
        return ($user->role->name == 'Admin' || $user->role->name == 'Owner') &&  $user->id === $hotel->user_id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hotel $hotel): bool
    {
        return ($user->role->name == 'Admin' || $user->role->name == 'Owner') &&  $user->id === $hotel->user_id ;
    }


  
}
