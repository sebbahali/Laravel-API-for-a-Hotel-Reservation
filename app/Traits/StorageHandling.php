<?php 

namespace App\Traits;
use Illuminate\Support\Facades\Storage;

trait StorageHandling
{

    public function DeleteStorage($image)
    {
        match(gettype($image)){

           'object' => $image->each(fn ($oldImage) =>

            (Storage::exists($oldImage)) ? Storage::delete($oldImage) :  \Log::error("Error deleting file: $image")),

           'string' =>  (Storage::exists($image))  ?  Storage::delete($image) :   \Log::error("Error deleting file: $image")

        };

        

    }


}
