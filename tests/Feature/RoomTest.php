<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;

class RoomTest extends TestCase
{

    use RefreshDatabase;
  
 
    public function testNotAuthCannotAccessRoomsGetEndpoint(): void
    {
        $response = $this->getJson('/api/v1/rooms');

        $response->assertStatus(401);
    }

    public function testRoomssEndpointReturnCorrectJsonData(): void
    {
      
        $hotel = Hotel::factory()->create();

        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->actingAs($this->user)->getJson('/api/v1/rooms');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            
            'adults' => $room->adults,
            'children' => $room->children,

            'images' => $room->files->map( fn($files) => Storage::disk('public')->url($files)),

            'hotel' => $hotel->toarray(),
        ]);

    }

    public function testUserCantUseRoomsEndpoint(){

        $hotel = Hotel::factory()->create(['user_id' => $this->user]);

        $room = Room::factory()->create(['hotel_id' => $hotel->id ,'images'=>null])->toarray();
    
        $response = $this->actingAs($this->user)->postJson('/api/v1/rooms', $room);

        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->putJson('/api/v1/rooms/'.$room['id'], $room);

        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->deleteJson('/api/v1/hotels/'.$room['id']);

        $response->assertStatus(403);


        
       }

    
       public function testOwnerCanUseRoomsEndpoint(){

        $hotel = Hotel::factory()->create(['user_id' => $this->owner]);

        $room = Room::factory()->create(['hotel_id' => $hotel->id ,'images'=>null])->toarray();
    
        $response = $this->actingAs($this->owner)->postJson('/api/v1/rooms', $room);

        $response->assertStatus(201);

        $updatedroom = Room::factory()->create(['hotel_id' => $hotel->id ,'images'=>null])->toarray();
           
        $response = $this->actingAs($this->owner)->putJson('/api/v1/rooms/'.$room['id'], $updatedroom);

        $response->assertStatus(200);

        $response = $this->actingAs($this->user)->deleteJson('/api/v1/hotels/'.$updatedroom['id']);

        $response->assertStatus(200);

       }
       
       public function testRoomShowEndpointReturnCorrectJsonData(): void
       {
           $hotel = Hotel::factory()->create();
    
           $room = Room::factory()->create(['hotel_id'=>$hotel->id]);
    
          
           $response = $this->actingAs($this->user)->getJson('/api/v1/rooms/'.$room['id']);
    
           $response->assertStatus(200);
    
           $response->assertJsonFragment([
                
            'adults' => $room->adults,
            'children' => $room->children,

            'images' => $room->files->map( fn($files) => Storage::disk('public')->url($files)),

            'hotel' => $hotel->toarray(),
    
        ]);
    
       }
       

}
