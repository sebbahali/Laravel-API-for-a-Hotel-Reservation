<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HotelTest extends TestCase
{
   use RefreshDatabase;
  
 
    public function testNotAuthintactedUserCannotAccessHotelsGetEndpoint(){

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

    $hotel = Hotel::factory()->create(['image'=>$file ,'user_id'=>$this->user->id])->toarray();

    $response = $this->actingAs($this->user)->postJson('/api/v1/hotels', $hotel);

    $response->assertStatus(403);

    $response = $this->actingAs($this->user)->putJson('/api/v1/hotels/'.$hotel['id'], $hotel);

    $response->assertStatus(403);

    $response = $this->actingAs($this->user)->deleteJson('/api/v1/hotels/'.$hotel['id']);

    $response->assertStatus(403);
    
   }

   public function testOwnerCanUseHotelsEndpoint(){

    $file = UploadedFile::fake()->image('image.jpg');

    $hotel = Hotel::factory()->create(['image'=>$file,'user_id'=>$this->owner->id])->toarray();

    $response = $this->actingAs($this->owner)->postJson('/api/v1/hotels', $hotel);

    $response->assertStatus(201);

    $updatehotel = Hotel::factory()->create(['image'=>$file,'user_id'=>$this->owner->id])->toarray();

    $response = $this->actingAs($this->owner)->putJson('/api/v1/hotels/'.$hotel['id'], $updatehotel);

    $response->assertStatus(200);

    $response = $this->actingAs($this->owner)->deleteJson('/api/v1/hotels/'.$updatehotel['id']);

    $response->assertStatus(200);


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
 

}

