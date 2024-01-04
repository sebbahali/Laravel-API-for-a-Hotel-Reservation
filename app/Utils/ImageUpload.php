<?php

namespace App\Utils;
use Illuminate\Support\Str;

class ImageUpload
{

    public static function uploadSingleImage($request)
    {

        $path = $request->file('image')->store('hotels', 'public');

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
