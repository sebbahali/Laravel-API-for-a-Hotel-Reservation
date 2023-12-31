<?php

namespace App\Http\Controllers\Api\V1\public;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;

class PublicController extends Controller
{
   public function __invoke(Request $request)
    {
    $hotels = Hotel::with(['rooms' => function($q) {
         $q->where('is_booked', 1)
         ->WhereNotNull('images');
    }])
        ->when($request->address, function ($query) use ($request) {

            $query->where('address', $request->address);

    })->when ($request->adults && $request->children ,function($query) use ($request){

        $query->withwherehas('rooms',function($query) use ($request) {
        $query->where('adults','>=',$request->adults)
        ->where('children','>=',$request->children);
        });
    })
    ->get(); 
        
        return HotelResource::collection($hotels);

    }
   
}

