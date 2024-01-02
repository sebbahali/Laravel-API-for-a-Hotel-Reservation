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

        $hotels = Hotel::query()
       
        ->when($request->address, function ($query) use ($request) {

            $query->where('address', $request->address);

        })->withwherehas('rooms', function($query) use ($request) {

            $query->when ($request->adults && $request->children , function($query) use ($request){

                $query->where('adults', '>=' , $request->adults)
                ->where('children', '>=' ,$request->children);
            }) 
            ->when ($request->from_price && $request->to_price , function($query) use ($request){

                $query->whereBetween('price',[$request->from_price,$request->to_price ]);
                
            });
        })
        ->get(); 



        return HotelResource::collection($hotels);

}
   
}

