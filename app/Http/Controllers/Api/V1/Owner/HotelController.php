<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Services\HotelService;




class HotelController extends Controller
{
    protected $hotelservice;
    

    public function __construct(HotelService $hotelservice)
    {
        $this->hotelservice = $hotelservice;
        
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
      
        $hotel = $this->hotelservice->HotelDataStore($request);
        
        return New HotelResource($hotel);
    
}

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel) //public
    {
     
        $hotel->load('rooms');
        
        return  New HotelResource($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, Hotel $hotel) //owner admin
    {
    

        $hotel = $this->hotelservice->HotelDataUpdate($request,$hotel);

        return New HotelResource($hotel);

    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel) //owner admin
    {

      $this->hotelservice->DeleteStorageHotel($hotel);

        return response()->json(['message'=>'hotel deleted']);

    }
}
