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
        $this->roomservice = $roomservice;   // Injecting 
        $this->middleware('role.check:Admin,Owner')->only(['store','update','destroy']);    // Applying middleware for role-based access

        $this->authorizeResource(Room::class ,'room',[
            'except' => [ 'index', 'show' ,'store'],
        ]);

    }
    public function index()  // Get all hotels
    {
        $rooms = $this->roomservice->getAll();

        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request) //owner admin
    {
      
        $rooms = $this->roomservice->Store($request);

        return new StoreRoomResource($rooms); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $Room) //public
    {
        $hotel = $this->roomservice->getByid($Room);

       
       return new RoomResource($Room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request , Room $Room) //owner admin
    {
       

        $Room = $this->roomservice->Update($request,$Room);

        return new  StoreRoomResource($Room); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $Room) //owner admin
    {

        $this->roomservice->Delete($Room);

        return response()->json(['message'=>'room deleted']);

    }
}

