<?php

namespace Tests\Feature;
use App\Models\Role;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HotelTest extends TestCase
{
   use RefreshDatabase;
  
    private User $user;
   private User $owner;

    protected function setUp() :void
    {

        parent::setUp();

        $this->user = $this->CreateUser();

      $this->owner =$this->CreateUser(3);

    }

    public function testNotAuthCannotAccessHotelsGetEndpoint(){


        $response = $this->getJson('/api/v1/hotels');

        $response->assertStatus(401);
        
    }

    public function testHotelsEndpointReturnCorrectJsonData(): void
    {
        $hotel = Hotel::factory()->create();

        $room = Room::factory()->create(['hotel_id'=>$hotel->id]);

        $response = $this->actingAs($this->user)->getJson('/api/v1/hotels');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            
            'name' => $hotel->name,
            'discreption' => $hotel->discreption,
            'image' => Storage::disk('public')->url($hotel->image),
            'address' => $hotel->address,
            'rooms' => [$room->toarray()],
        ]);

    }


public function testUserCantHotelsPostEndpoint(){

    $file = UploadedFile::fake()->image('image.jpg');


    $hotel = Hotel::factory()->create(['image'=>$file])->toarray();

    $response = $this->actingAs($this->user)->postJson('/api/v1/hotels', $hotel);
       
    $response->assertStatus(403);
    
   }

   public function testOwnerCanUseHotelsPostEndpoint(){

    $file = UploadedFile::fake()->image('image.jpg');


    $data = Hotel::factory()->create(['image'=>$file])->toarray();

    $response = $this->actingAs($this->owner)->postJson('/api/v1/hotels', $data);
       
    $response->assertStatus(201);

   }

   public function  testOwnerCanUseHotelsPutEndpoint(){
    
    $file = UploadedFile::fake()->image('image.jpg');

    $hotel = Hotel::factory()->create(['image'=>$file,'user_id'=>$this->owner->id])->toarray();


    $response = $this->actingAs($this->owner)->putJson('/api/v1/hotels/'.$hotel['id'], $hotel);
       
    $response->assertStatus(200);


   }
   public function testUserCantUseHotelsPutEndpoint(){
    
    $file = UploadedFile::fake()->image('image.jpg');

    $hotel = Hotel::factory()->create(['image'=>$file,'user_id'=>$this->user->id])->toarray();

    $response = $this->actingAs($this->user)->putJson('/api/v1/hotels/'.$hotel['id'], $hotel);
       
    $response->assertStatus(403);


   }
   public function testHotelsShowEndpointReturnCorrectJsonData(): void
   {
       $hotel = Hotel::factory()->create();

       $room = Room::factory()->create(['hotel_id'=>$hotel->id]);

      
       $response = $this->actingAs($this->user)->getJson('/api/v1/hotels/'.$hotel['id']);

       $response->assertStatus(200);

       $response->assertJsonFragment([
            
        'name' => $hotel->name,
        'discreption' => $hotel->discreption,
        'image' => Storage::disk('public')->url($hotel->image),
        'address' => $hotel->address,
        'rooms' => [$room->toarray()],
    ]);

   }
   public function testOwnerCanUseHotelsDeleteEndpoint(){
    

    $spesificdata= Hotel::factory()->create(['user_id'=>$this->owner->id]);

    $response = $this->actingAs($this->owner)->deleteJson('/api/v1/hotels/'.$spesificdata['id']);
       
    $response->assertStatus(200);


   }
   public function testUserCantUseHotelsDeleteEndpoint()
   {
    
    $hotel = Hotel::factory()->create();

    $response = $this->actingAs($this->user)->deleteJson('/api/v1/hotels/'.$hotel['id']);
       
    $response->assertStatus(403);

   }
private function CreateUser(int $id=1) :User

{
  
    return User::factory()->create(['role_id'=>$id]);

}

}

