<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_name', 'quantity'];
	public $timestamps = false;

    public function addProduct($product_name, $quantity){
    	return self::updateOrCreate([
    		'product_name' => $product_name,
    		'quantity' => $quantity
    	]);
    }

    public function removeProduct($product_name){
    	return self::where('product_name', $product_name)->delete();
    }

    public function showCart(){
    	$carts = self::all();
    	$result = '';
    	foreach($carts as $cart){
    		$result .= $cart->product_name.' ('.$cart->quantity.') <br/>';
    	}
    	return $result;
    }
}
