<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Services\LogicService;




class HotelController extends Controller
{
    protected $logicservice;


    public function __construct(LogicService $logicservice)
    {
        $this->logicservice = $logicservice;
        $this->authorizeResource(Hotel::class ,'hotel', [
            'except' => [ 'index', 'show' ],
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() //public 
    {
     $hotels = Hotel::with('rooms')->get();
        
     return HotelResource::collection($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request) //owner admin 
    {
      
     $data = $this->logicservice->HotelData($request);


        $hotel = Hotel::create($data);
        
        return New HotelResource($hotel);
    
}

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel) //public
    {
     
        $hotel->load(['rooms'=>function ($q){
            $q->where('is_booked',false);
          }]);
        
        return  New HotelResource($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, Hotel $hotel) //owner admin
    {

        $data = $this->logicservice->HotelData($request,$hotel);
    
        $hotel->update($data);

        return New HotelResource($hotel);
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel) //owner admin
    {

      $this->logicservice->DeleteStorage($hotel->image);
        
        $hotel->delete();

        return response()->json(['message'=>'hotel deleted']);

    }
}
