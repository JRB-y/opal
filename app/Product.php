<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'desc', 'in_stock', 'image_id', 'prix'];
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function main()
    {
        return $this->hasOne(Image::class);
    }

}
