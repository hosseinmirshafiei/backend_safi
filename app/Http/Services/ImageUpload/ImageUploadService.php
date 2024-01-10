<?php
namespace App\Http\Services\ImageUpload;
use Illuminate\Support\Str;
use Image;
class ImageUploadService{
    public static function UploadImage($path , $request , $request_key , $response_key){
        if ($request->hasFile($request_key)) {
            $image = $request->file($request_key);
            $randomStr = Str::random(40);
            $file_name =  date('mdYHis') . '-' . $randomStr . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $img = Image::make($image->getRealPath());
            $img->save(public_path($path).'/'.$file_name , 80);

            $final_image_name = $path . $file_name;
            return $final_image_name;
        }
    }
}