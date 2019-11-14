<?php

namespace App\Http\Controllers\Products;

use App\Image;
use App\Product;
use App\MainImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Images\ImagesController;

class ProductsController extends Controller
{
    /**
     * $img
     *
     * @var undefined
     */
    public $img;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->img = new ImagesController();
    }

    public function index()
    {
        return Product::orderBy('created_at', 'desc')->with('images', 'image')->get();
    }

    public function productGrid($offset)
    {
        return Product::orderBy('created_at', 'desc')
            ->with('images', 'image')
            ->offset($offset)->limit(12)->get();
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|unique:products|max:255',
            'desc' => 'required',
            'in_stock' => 'required',
        ]);
        $product = Product::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'in_stock' => $request->in_stock,
            'prix' => 0,
            'image_id' => null
        ]);
        $image = $this->img->saveImage(Input::file('image'), $product);
        $product->image_id = $image->id;
        $product->save();
        return $product;
    }
    public function show($id)
    {
        return Product::where('id', $id)->with('images')->with('image')->first();
    }

    public function update(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|max:255',
            'desc' => 'required',
            'in_stock' => 'required',
        ]);

        $product = Product::find($request->id);

        if ($request->image != "[object Object]") {
            // $image = $this->replaceImage(Input::file('image'), $product);
            $image = $this->img->replaceImage(Input::file('image'), $product);
            $product->image_id = $image[0]->id;
            $product->save();
            $image[1]->delete();
        }


        if ($product->update($request->all())) {
            return response()->json(['msg' => $product->name . ' updated with sucess !']);
        }
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $mainImageId = $product->image_id;

        $product->image_id = null;
        $product->save();
        $product->delete();

        $mainImage = MainImage::find($mainImageId);
        if (File::exists(public_path($mainImage->path))) {
            File::delete(public_path($mainImage->path));
        }
        $mainImage->delete();

        $this->img->deleteImage($request->id);
        return response()->json(['msg' => $request->id . ' deleted with success !']);
    }





    public function countProducts()
    {
        $count = Product::count();

        return response()->json($count);
    }
}
