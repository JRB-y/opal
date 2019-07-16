<?php

namespace App\Http\Controllers\Products;

use App\Image;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('images')->with('image')->get();
    }

    public function productGrid($offset)
    {
        return Product::with('images')->with('image')->offset($offset)->limit(12)->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $image = $this->saveImage(Input::file('image'), $product);
        $product->image_id = $image->id;
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        
        if($request->image != "undefined"){
            $image = $this->replaceImage(Input::file('image'), $product);
            $product->image_id = $image[0]->id;
            $product->save();
            $image[1]->delete();
        }


        if($product->update($request->all())){
            return response()->json( [ 'msg' => $product->name . ' updated with sucess !' ] );
        }
        
    }

    public function delete(Request $request)
    {
        // find the product
        // delete images of the product from DB
        // delete images of the product from server
        // delete the product

        $product = Product::find($request->id);
        $product->delete();

        $imagesToDelete = Image::where('product_id', $request->id)->get();
        foreach($imagesToDelete as $img){
            if(File::exists(public_path($img->path))) {
                File::delete(public_path($img->path));
            }
            $img->delete();
        }
        

        return response()->json( [ 'msg' => $request->id . ' deleted with success !' ] );
    }

    protected function saveImage($image, $product)
    {
        $image_name = trim(str_replace(' ', '_', $image->getClientOriginalName()));
        $path = 'uploads/' . $product->id;
        $image->move($path, $image_name);

        $imageCreated = Image::create([
            'path' => '/uploads/'  . $product->id. '/' .$image_name,
            'product_id' => $product->id
        ]);

        return $imageCreated;
    }

    protected function replaceImage($image, $product)
    {
        
        $oldImage = $product->image;
        if(File::exists(public_path($oldImage->path))) {
            File::delete(public_path($oldImage->path));
        }

        
        
        $image_name = trim(str_replace(' ', '_', $image->getClientOriginalName()));
        $path = 'uploads/' . $product->id;
        $image->move($path, $image_name);

        $imageCreated = Image::create([
            'path' => '/uploads/'  . $product->id. '/' .$image_name,
            'product_id' => $product->id
        ]);

        

        return [$imageCreated, $oldImage];
    }

    public function countProducts()
    {
        $count = Product::count();
        
        return response()->json( $count );
    }
}
