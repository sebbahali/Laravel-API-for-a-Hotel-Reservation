<?php
namespace App\Services;

use App\Models\Hotel;
use App\Utils\ImageUpload;
use Illuminate\Support\Facades\Storage;

class HotelService  
{

  public function getAll()
  {

   return Hotel::with('rooms')->get();

  }
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

