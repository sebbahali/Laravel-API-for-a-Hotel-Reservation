<?php

namespace App\Policies;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HotelPolicy
{
   
  

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user , Hotel $hotel): Response
    {
        return   $this->getResponse($user->id === $hotel->user_id);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hotel $hotel) : Response
    {
        return   $this->getResponse($user->id === $hotel->user_id);

    }
  
    
    private function getResponse(bool $hasPermission): Response
    {
        return $hasPermission
            ? Response::allow()
            : Response::deny('You do not have permission');
    }
    
}
