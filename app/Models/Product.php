<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "products";
    

    
     public function cat(){

        return $this->BelongsTo('App\Models\ProductCategory','category_id');
    }
}
