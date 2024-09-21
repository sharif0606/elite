<?php

namespace App\Models\Release;

use App\Models\Stock\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseEmployeeDetail extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class,'issue_item_id','id');
    }
}
