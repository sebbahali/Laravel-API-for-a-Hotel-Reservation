<?php
namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;

class HotelService  
{

  public function getAll()
  {

   return Hotel::with('rooms')->get();

  }
    public function Store($request)
     {

      try{

         $path = $request->file('image')->store('hotels', 'public');

         $request['image'] = $path;

      
         $hotel = Hotel::create($request);

          return $hotel;
           
      } catch(\Exception $e)
      {
        return response()->json([
          'message'=>$e
       ]);

      }
        
    }
    public function getByid($hotel)
     {

      return $hotel->load('rooms');
   }

   
    public function Update($request , $hotel)
    {

      try {

         $path = $request->file('image')->store('hotels', 'public');

          $this->Delete($hotel->image);  
          
          $request['image'] = $path;  
           
          $hotel->update($request);
          
          return $hotel;

      }catch(\Exception $e)
      {

        return response()->json([
          'message'=>$e
       ]);

        
      }
      

   }

 
     public function Delete($hotel)
     {
        
       (Storage::exists($hotel->image)) ? Storage::delete($hotel->image) :  
         \Log::error("Error deleting file: $hotel->image");

         $hotel->delete();
       
     }
    }

