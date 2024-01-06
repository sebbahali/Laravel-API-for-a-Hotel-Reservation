<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $user;
    public User $owner;
 
    protected function setUp() :void
    {

        parent::setUp();

        $this->user = $this->CreateUser();

      $this->owner =$this->CreateUser(3);

    } 
      private function CreateUser(int $id=1) :User

{ 
  
    return User::factory()->create(['role_id'=>$id]);

}

}
