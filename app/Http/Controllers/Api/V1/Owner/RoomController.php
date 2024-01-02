<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Http\Resources\StoreRoomResource;
use App\Models\Room; 

use App\Services\RoomService;


class RoomController extends Controller
{
    protected $roomservice;


    /**
     * Display a listing of the resource.
     */
    public function __construct(RoomService $roomservice)
    {
        $this->roomservice = $roomservice;

        $this->authorizeResource(Room::class ,'room',[
            'except' => [ 'index', 'show' ],
        ]);

    }
    public function index() //public
    {
        $rooms = Room::with('hotel')->get();

        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request) //owner admin
    {
      
        $rooms = $this->roomservice->RoomDataStore($request);

        return new StoreRoomResource($rooms); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $Room) //public
    {
       $Room->load('hotel')->get();
       
       return new RoomResource($Room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request , Room $Room) //owner admin
    {
       

        $Room = $this->roomservice->RoomDataUpdate($request,$Room);

        return new RoomResource($Room); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $Room) //owner admin
    {

        $this->roomservice->DeleteStorageRoom($Room);

        return response()->json(['message'=>'room deleted']);

    }
}

