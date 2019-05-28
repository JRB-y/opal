<?php

namespace App;

use App\Image;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function main()
    {
        return $this->hasOne(Image::class);
    }

}
