<?php
namespace App\Services;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;


   class RoomService
   
{
   public function getAll(){

      return Room::with('hotel')->get();
       
    
       }
   
     public function RoomDataStore( $request )

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
   
    public function RoomDataUpdate( $request ,$Room )

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
        
             $this->Delete($Room->files);
    
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

      

     }
    }

