<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
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
        $hotels = $this->hotelservice->getAll();
    
        return HotelResource::collection($hotels);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request) //owner admin 
    {
      
        $hotel = $this->hotelservice->Store($request);
        
        return New HotelResource($hotel);
    
}

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel) //public
    {
        
       
        $hotel = $this->hotelservice->getByid($hotel);

      return  New HotelResource($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel) //owner admin
    {

        $hotel = $this->hotelservice->Update($request,$hotel);

        return New HotelResource($hotel);

    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel) //owner admin
    {

      $this->hotelservice->Delete($hotel);

      return response()->json(['message'=>'hotel deleted']);
      

    }
}
