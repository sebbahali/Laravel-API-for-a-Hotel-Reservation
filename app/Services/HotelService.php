<?php
namespace App\Services;


use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;



   class HotelService
   
{
     public function HotelDataStore($request)
     {

        $data = $request->validated();

        $requestfile = $request->file('image');

        if ($requestfile->isValid()) {

         $path = $requestfile->store('hotels', 'public');

         $data['image'] = $path;

        } 
           $hotel = Hotel::create($data);

           return $hotel;
    }

    public function HotelDataUpdate($request , $hotel)

    {

        $data = $request->validated();

        $requestfile = $request->file('image');

        if ($requestfile->isValid()) {

         $path = $requestfile->store('hotels', 'public');

         $data['image'] = $path;

          $this->DeleteStorageHotel($hotel->image);     
        }

      $hotel->update($data);

      return $hotel;
      
   }
 
     public function DeleteStorageHotel($hotel)
     {
        
       (Storage::exists($hotel->image)) ? Storage::delete($hotel->image) :  
         \Log::error("Error deleting file: $hotel->image");

         $hotel->delete();
       
     }
    }

