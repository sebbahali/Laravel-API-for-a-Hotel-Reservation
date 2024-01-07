<?php

namespace App\Utils;
use Illuminate\Support\Str;

class ImageUpload
{

      public static function uploadSingleImage($request)
    {
        $name = str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();       

        $path = $request->file('image')->storeAs('hotels', $name);

        return $path;
      
    }


    public static function uploadMultipleImages($request)
    {

        $image = $request->file('images');

        foreach($image as $file) {

            $name = str::uuid() . '.' . $file->getClientOriginalExtension();           
            
            $file->storeAs('rooms',$name) ;

             $files[] = 'rooms/'.$name;
         
          }  
    
       return  $files;
      
    }
}
