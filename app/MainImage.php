<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class MainImage extends Model
{
    protected $table = 'main_images';
    protected $fillable = ['path', 'product_id', 'id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
