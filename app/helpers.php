<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Wishlist;
use App\Models\Review;

function list_of_categories()
{
    return Category::all();
}

function total_wishlists()
{
    return Wishlist::where('user_id', auth()->id())->count();
}
function total_carts()
{
    return Cart::where('user_id', auth()->id())->count();
}
function carts()
{
    return Cart::where('user_id', auth()->id())->get();
}
function stock($product_id, $color_id, $size_id)
{
    return Inventory::where([
        'product_id' => $product_id,
        'color_id' => $color_id,
        'size_id' => $size_id,
    ])->first()->quantity;
    // return Cart::where('user_id', auth()->id())->get();
}
function stars($product_id)
{
    return round(Review::where('product_id', $product_id)->avg('rating'));
}
