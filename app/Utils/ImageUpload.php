<?php

namespace App\Utils;
use Illuminate\Support\Str;

class ImageUpload
{
  /**
     * Upload a single image.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
      public static function uploadSingleImage($request)
    {
    // Generate a unique filename using UUID and get the original file extension

        $name = str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();       

        $path = $request->file('image')->storeAs('hotels', $name);

        return $path;
      
    }

   /**
     * Upload multiple images.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function uploadMultipleImages($request)
    {

        $image = $request->file('images');

        foreach($image as $file) {

            $name = str::uuid() . '.' . $file->getClientOriginalExtension();           
            
            $file->storeAs('rooms',$name) ;

             $files[] = 'rooms/'.$name;  // Store the path of each stored image in the array
         
          }  
    
       return  $files;
      
    }
}
