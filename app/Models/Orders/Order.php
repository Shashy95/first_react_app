<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     use HasFactory;
    protected $table = "orders";
    protected  $guarded = ['id'];


    public function invoice_items(){

        return $this->hasMany('App\Models\Order\OrderItems','id');
    }
    
    public function client(){
    
        return $this->BelongsTo('App\Models\User','user_id');
    }
    
    
}
