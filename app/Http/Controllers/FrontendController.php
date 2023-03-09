<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Featured_photo;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeUnitReverseLookup\Wizard;

class FrontendController extends Controller
{
    function index(){
        return view('index',[
            "products" => Product::latest()->get(),
            "categories" => Category::all(),
        ]);
    }
    function product_details($id){
        $product = Product::find($id);
        $related_products = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->get();
        $vendor = User::find($product->user_id);
        $featured_photos = Featured_photo::where('product_id', $id)->get();
        $inventories = Inventory::where('product_id', $id)->with('relationshiptosize')->get();
        return view('product_details', compact('product', 'featured_photos', 'vendor', 'related_products', 'inventories'));
    }
    function about(){
        $friends = ['Rayan', 'Al-Amin', 'Shawon', 'Masum', 'Azmir', 'Saydul'];
        $enemies = ['Arif', 'Tahsan'];
        $gender = "Male";
        return view('about', compact('friends', 'enemies', 'gender'));
    }
    function shop($category_id){
        if($category_id == 'all'){
            $products = Product::all();
        }else{
            $products = Product::where('category_id', $category_id)->get();
        }
        return view('shop', compact('products'));
    }
    function contact(){
        return view('contact');
    }
    function category(){
        $categories = Category::latest()->get();
        return view('category', compact('categories'));
    }
    function wishlist(){
        $wishlists = Wishlist::where('user_id', auth()->id())->with('relationtoproduct')->latest()->get();
        return view('wishlist', compact('wishlists'));
    }
    function add_to_wishlist($id){
        Wishlist::insert([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'created_at' => Carbon::now()
        ]);
        return back();
    }
    function remove_from_wishlist($id){
        Wishlist::find($id)->delete();
        return back();
    }
    function custom_login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back();
        }
        else{
            return back()->with('login_error', 'Your email or password is wrong');
        }
    }
    function get_color_list(Request $request){
        $generated_options = "<option value=''>-Select One Color-</option>";
        $inventories = Inventory::where([
            'size_id' => $request->size_id,
            'product_id' => $request->product_id,
        ])->get();
        foreach ($inventories as $inventory) {
            $generated_options .= "<option value='".$inventory->relationshiptocolor->id."'>".$inventory->relationshiptocolor->name."(Stock:".$inventory->quantity.")</option>";
        }
        return $generated_options;
    }
    function add_to_cart(Request $request){
        $real_stock = Inventory::where([
            'product_id' => $request->d_product_id,
            'size_id' => $request->d_size_id,
            'color_id' => $request->d_color_id,
        ])->first()->quantity;
        if($request->user_quantity <= 0){
            echo "bad number";
        }else{
            if($real_stock < $request->user_quantity){
                echo "Add to cart not possible";
            }else{
                //now you can add this product to the cart - start
                //check if exists
                if(Cart::where([
                    'user_id' => auth()->id(),
                    'product_id' => $request->d_product_id,
                    'size_id' => $request->d_size_id,
                    'color_id' => $request->d_color_id
                ])->exists()){
                    Cart::where([
                        'user_id' => auth()->id(),
                        'product_id' => $request->d_product_id,
                        'size_id' => $request->d_size_id,
                        'color_id' => $request->d_color_id
                    ])->increment('amount', $request->user_quantity);
                }
                else{
                    Cart::insert([
                        'user_id' => auth()->id(),
                        'product_id' => $request->d_product_id,
                        'size_id' => $request->d_size_id,
                        'color_id' => $request->d_color_id,
                        'amount' => $request->user_quantity,
                        'created_at' => Carbon::now()
                    ]);
                }
                echo "success";
                //now you can add this product to the cart - end
            }
        }
    }
    function remove_from_cart($id)
    {
        Cart::find($id)->delete();
        return back();
    }
    function cart()
    {
        if (isset($_GET['coupon_name'])) {
            $coupon_name = $_GET['coupon_name'];
            $coupon = Coupon::where('coupon_name', $coupon_name)->first();
            if(Coupon::where('coupon_name', $coupon_name)->exists()){
                if(Carbon::now() > Carbon::parse($coupon->coupon_validity)){
                    return redirect('cart')->with('error', 'Coupon Date Expired');
                }else{
                    if($coupon->coupon_limit == 0){
                        return redirect('cart')->with('error', 'This coupon limit has exceeded');
                    }
                    else{
                        $discount = $coupon->coupon_discount;
                        return view('cart', compact('discount', 'coupon_name'));
                    }
                }
            }else{
                return redirect('cart')->with('error', 'This coupon does not exists');
            }
        }else{
            $discount = 0;
            $coupon_name = "";
            return view('cart', compact('discount', 'coupon_name'));
        }
    }
    function update_cart(Request $request)
    {
        foreach ($request->quantity as $cart_id => $updated_quantity) {
            Cart::find($cart_id)->update([
                'amount' => $updated_quantity
            ]);
        }
        return back();
    }
    function checkout()
    {
        if(strpos(url()->previous(), "cart") || strpos(url()->previous(), "checkout")){
            $addresses = Address::where('user_id', auth()->id())->get();
            return view('checkout', compact('addresses'));
        }
        else{
            abort(404);
        }
    }
    function add_address(Request $request)
    {
        Address::insert([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'customer_name' => $request->customer_name,
            'full_address' => $request->full_address,
            'zip_code' => $request->zip_code,
            'phone_number' => $request->phone_number,
            'created_at' => Carbon::now()
        ]);
        return back();
    }
}
