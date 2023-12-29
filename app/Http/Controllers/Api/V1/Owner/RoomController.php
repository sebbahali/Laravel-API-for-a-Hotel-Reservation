<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room; 

use App\Services\LogicService;


class RoomController extends Controller
{
    protected $logicservice;


    /**
     * Display a listing of the resource.
     */
    public function __construct(LogicService $logicservice)
    {
        $this->logicservice = $logicservice;
        
        $this->authorizeResource(Room::class ,'room',[
            'except' => [ 'index', 'show' ],
        ]);

    }
    public function index() //public
    {
        $rooms = Room::with('hotel')->where('is_booked',1)->get();

        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request) //owner admin
    {
      
        $data = $this->logicservice->RoomData($request);


        $rooms = Room::create($data);
       
         return new RoomResource($rooms); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $Room) //public
    {
       $Room->load('hotel')->where('is_booked',1)->get();
       
       return new RoomResource($Room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request , Room $Room) //owner admin
    {
       

        $data = $this->logicservice->RoomData($request,$Room);

        $Room->update($data);

        return new RoomResource($Room); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $Room) //owner admin
    {

        $this->logicservice->DeleteStorage($Room->files);

        $Room->delete();

        return response()->json(['message'=>'room deleted']);

    }
}

