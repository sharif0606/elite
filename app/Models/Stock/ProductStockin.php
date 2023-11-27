<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock\Product;
use App\Models\Stock\ProductSize;

class ProductStockin extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function size(){
        return $this->belongsTo(ProductSize::class,'size_id','id');
    }
}
