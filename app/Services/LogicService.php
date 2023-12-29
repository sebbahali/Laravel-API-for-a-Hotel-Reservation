<?php
namespace App\Services;

use App\Http\Requests\HotelRequest;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;


   class LogicService
   
{
     public function HotelData(HotelRequest $request , $hotel = null)

    {

        $data = $request->validated();

        $requestfile = $request->file('image');

     if ($requestfile->isValid()) {

         $path = $requestfile->store('hotels', 'public');

         $data['image'] = $path;

         if($hotel) {

            $this->DeleteStorage($hotel->image);     
        }
     } 
        return $data;
      }

     public function RoomData(RoomRequest $request ,$Room = null )

     {

    
        $data = $request->validated();

        try{

         if ($request->hasFile('images')) {
  
            $image = $request->file('images');

            foreach($image as $file) {

                $name = str::uuid() . '.' . $file->getClientOriginalExtension();           
                
                $file->storeAs('rooms',$name) ;

                $files[] = 'rooms/'.$name;
             
              }  
              
            $data['images'] = json_encode($files);
            
            if ($Room) {

              $this->DeleteStorage($Room->files);
     
           }
        }
      }
           catch (\Exception $e)
           { 

            return response()->json([
               'message'=>$e
            ]);

           }
                    return $data;
           
    }
  
 
     public function DeleteStorage($image)
     {
         match(gettype($image)){ // 
 
            'object' =>  $image->each(fn ($oldImage) =>
 
            (Storage::exists($oldImage)) ? Storage::delete($oldImage) :  \Log::error("Error deleting file: $image")),
 
            'string' =>  (Storage::exists($image))  ?  Storage::delete($image) :   \Log::error("Error deleting file: $image")
 
         };
 
     }
    }

