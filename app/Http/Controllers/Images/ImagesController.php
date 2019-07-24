<?php
namespace App\Http\Controllers\Images;

// use App\Image;
use App\Image;
use App\MainImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class ImagesController extends Controller
{
    public function saveImage($image, $product)
    {

        $image_name = trim(str_replace(' ', '_', $image->getClientOriginalName()));
        $path = 'uploads/' . $product->id;
        $image->move($path, $image_name);
        $imageCreated = MainImage::create([
            'path' => '/uploads/'  . $product->id. '/' .$image_name,
            'product_id' => $product->id
        ]);
        return $imageCreated;
    }

    public function replaceImage($image, $product)
    {
        $oldImage = $product->image;
        if(File::exists(public_path($oldImage->path))) {
            File::delete(public_path($oldImage->path));
        }
        $image_name = trim(str_replace(' ', '_', $image->getClientOriginalName()));
        $path = 'uploads/' . $product->id;

        $image->move($path, $image_name);
        $imageCreated = MainImage::create([
            'path' => '/uploads/'  . $product->id. '/' .$image_name,
            'product_id' => $product->id
        ]);
        return [$imageCreated, $oldImage];
    }

    public function deleteImage($id)
    {
        $imagesToDelete = Image::where('product_id', $id)->get();
        foreach($imagesToDelete as $img){
            if(File::exists(public_path($img->path))) {
                File::delete(public_path($img->path));
            }
            $img->delete();
        }   
    }

    public function updateSecondaryImage(Request $request)
    {
        if(Input::file('image') != "undefined"){
            $image = Input::file('image');
            $image_name = trim(str_replace(' ', '_', $image->getClientOriginalName()));
            $path = 'uploads/' . $request->productId;
            $image->move($path, $image_name);
            $imageCreated = Image::create([
                'path' => '/uploads/'  . $request->productId. '/' .$image_name,
                'product_id' => $request->productId
            ]);
        }
    }

    public function deleteSecondary(Request $request)
    {
        $image = Image::find($request->imageId);
        if(File::exists(public_path($image->path))) {
            File::delete(public_path($image->path));
        }
        $image->delete();

        return response()->json( [ 'msg' => 'Image deleted with success !' ] );
    }

    public function compress($source, $destination, $quality) {
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
            
		elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
            
		elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
            
		imagejpeg($image, $destination, $quality);
		return $destination;
	}
}