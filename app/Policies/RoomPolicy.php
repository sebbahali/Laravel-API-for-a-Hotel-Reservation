<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
 
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->name == "Admin" || $user->role->name == 'Owner';

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user,Room $Room): bool
    {
        return ($user->role->name == 'Admin' || $user->role->name == 'Owner') &&  $user->id === $Room->hotel->user_id ;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,Room $Room): bool
    {
        
       return ($user->role->name == 'Admin' || $user->role->name == 'Owner') &&  $user->id === $Room->hotel->user_id ;

    }

    /**
     * Determine whether the user can restore the model.
     */
 
}
