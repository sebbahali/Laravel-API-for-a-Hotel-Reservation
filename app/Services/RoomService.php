<?php
namespace App\Services;

use App\Models\Room;
use App\Utils\ImageUpload;
use Illuminate\Support\Facades\Storage;
use Exception;

   class RoomService
   
{
   public function getAll(){

      return Room::with('hotel')->get();
       
      }
   
     public function  Store($request)
     {
    
        $data = $request->validated();

        try{

         if ($request->hasFile('images')) {
  
            $files = ImageUpload::uploadMultipleImages($request);

            $data['images'] = json_encode($files);
            }
      
         }
           catch (\Exception $e)
           { 

            return response()->json([
               'message'=>$e
            ]);

           }
           
           return Room::create($data);
                    
           
    }
    public function getByid($Room){
  
      return $Room->load('hotel')->get();
   }
   
    public function Update($request ,$Room )

    {
   
       $data = $request->validated();

       try{

        if ($request->hasFile('images')) {
 
         $files = ImageUpload::uploadMultipleImages($request);
             
           $data['images'] = json_encode($files);
        
         }

     }
          catch (\Exception $e)
          { 

           return response()->json([
              'message'=>$e
           ]);

          }
          $Room->update($data);

          return $Room;

   }


     public function Delete($room)
     {
         $room->files->each(fn ($oldImage) =>
 
            (Storage::exists($oldImage)) ? Storage::delete($oldImage) :  \Log::error("Error deleting file: $room->files"));

            $room->delete();
     }
    }

