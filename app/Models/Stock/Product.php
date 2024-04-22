<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock\Category;
use DB;

class Product extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function stock(){
        return $this->hasMany(Stock::class);
    }
    public function size(){
        return $this->belongsTo(ProductSize::class,'size_id','id');
    }
}
