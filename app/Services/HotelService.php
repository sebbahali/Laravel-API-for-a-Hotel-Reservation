<?php
namespace App\Services;

use App\Models\Hotel;
use App\Utils\ImageUpload;
use Illuminate\Support\Facades\Storage;

class HotelService  
{
 /**
     * Get all hotels with their rooms.
     *
     */
  public function getAll()
  {

   return Hotel::with('rooms')->get();

  }
   /**
     * Store a new hotel.
     */
    public function Store($request)
     {
      $data = $request->validated();
      
      try{

        if ($request->hasfile('image')) {

          $path=ImageUpload::uploadSingleImage($request);
          
          $data['image'] = $path;

        }
      
         $hotel = Hotel::create($data);

          return $hotel;
         
           
      } catch(\Exception $e)
      {
        return response()->json([
          'message'=>$e
       ]);

      }
         /**
     * Get a specific hotel by ID with its rooms.
     *
     * @param \App\Models\Hotel $hotel
     * @return \App\Models\Hotel
     */  
    }
    public function getByid($hotel)
     {

      return $hotel->load('rooms');
   }


    public function Update($request , $hotel)
    {
      $data = $request->validated();

      try {
        if ($request->hasfile('image')) {

          $path=ImageUpload::uploadSingleImage($request);
          
          $data['image'] = $path;

        }
      
                     
          $hotel->update($data);
          
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
      (Storage::exists($hotel->image)) ? Storage::delete($hotel->image) :  \Log::error("Error deleting file: $hotel->image)"); 
    
      $hotel->delete();
     }
    }

