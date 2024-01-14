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

        $response->assertStatus(401);// Assert that the response is (Unauthorized)
        
    }

    public function testHotelsEndpointReturnCorrectJsonData(): void
    {
        $hotel = Hotel::factory()->create();

        $room = Room::factory()->create(['hotel_id'=>$hotel->id]);

        $response = $this->actingAs($this->user)->getJson('/api/v1/hotels');   // Simulate an authenticated user and fetch hotels

        $response->assertStatus(200);   // Assert that the response status is (OK)
   // Assert that the JSON response contains expected data
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

    $response = $this->actingAs($this->user)->postJson('/api/v1/hotels', $hotel);  // Attempt to post a new hotel (403 expected as a regular user)

    $response->assertStatus(403);

    $response = $this->actingAs($this->user)->putJson('/api/v1/hotels/'.$hotel['id'], $hotel); 

    $response->assertStatus(403);

    $response = $this->actingAs($this->user)->deleteJson('/api/v1/hotels/'.$hotel['id']);

    $response->assertStatus(403);
    
   }

   public function testOwnerCanUseHotelsEndpoint(){


    $file ='image.jpg';

    $hotel = Hotel::factory()->create(['image'=> UploadedFile::fake()->image($file),'user_id'=>$this->owner->id])->toarray();

    $response = $this->actingAs($this->owner)->postJson('/api/v1/hotels', $hotel);    // Post a new hotel as an owner (201 expected)

    $response->assertStatus(201);

    $updatehotel = [
        'name' => 'anytest',
        'discreption' => 'test',
        'image' => UploadedFile::fake()->image($file),
        'address' => 'testvile',
        'user_id' => $this->owner->id,
    ];

    $response = $this->actingAs($this->owner)->putJson('/api/v1/hotels/'.$hotel['id'], $updatehotel);

    $response->assertStatus(200);

    $response = $this->actingAs($this->owner)->deleteJson('/api/v1/hotels/'.$hotel['id']);

    $response->assertStatus(200);


   }
 
   public function testHotelsShowEndpointReturnCorrectJsonData(): void
   {
       $hotel = Hotel::factory()->create();

       $room = Room::factory()->create(['hotel_id'=>$hotel->id]);

        // Simulate an authenticated user and fetch a specific hote
       $response = $this->actingAs($this->user)->getJson('/api/v1/hotels/'.$hotel['id']);

       $response->assertStatus(200);
   // Assert that the JSON response contains expected data
       $response->assertJsonFragment([
            
        'name' => $hotel->name,
        'discreption' => $hotel->discreption,
        'image' => Storage::disk('public')->url($hotel->image),
        'address' => $hotel->address,
        'rooms' => [$room->toarray()],
    ]);

   }
 

}

