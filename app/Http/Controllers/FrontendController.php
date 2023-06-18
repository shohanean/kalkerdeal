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
use App\Models\Invoice;
use App\Models\Invoice_detail;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeUnitReverseLookup\Wizard;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    function index()
    {
        return view('index', [
            "products" => Product::latest()->get(),
            "categories" => Category::all(),
        ]);
    }
    function product_details($id)
    {

        $product = Product::find($id);
        $reviews = Review::where('product_id', $id)->get();
        $related_products = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->get();
        $vendor = User::find($product->user_id);
        $vendor_reviews = Review::where('vendor_id', $vendor->id)->get();
        $featured_photos = Featured_photo::where('product_id', $id)->get();
        $inventories = Inventory::where('product_id', $id)->with('relationshiptosize')->get();
        return view('product_details', compact('reviews', 'product', 'featured_photos', 'vendor', 'related_products', 'inventories', 'vendor_reviews'));
    }
    function about()
    {
        $friends = ['Rayan', 'Al-Amin', 'Shawon', 'Masum', 'Azmir', 'Saydul'];
        $enemies = ['Arif', 'Tahsan'];
        $gender = "Male";
        return view('about', compact('friends', 'enemies', 'gender'));
    }
    function shop($category_slug)
    {
        if ($category_slug == 'all') {
            $products = Product::all();
        } else {
            $category_id = Category::where('slug', $category_slug)->first()->id;
            $products = Product::where('category_id', $category_id)->get();
        }
        return view('shop', compact('products'));
    }
    function contact()
    {
        return view('contact');
    }
    function category()
    {
        $categories = Category::latest()->get();
        return view('category', compact('categories'));
    }
    function wishlist()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())->with('relationtoproduct')->latest()->get();
        return view('wishlist', compact('wishlists'));
    }
    function add_to_wishlist($id)
    {
        Wishlist::insert([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'created_at' => Carbon::now()
        ]);
        return back();
    }
    function remove_from_wishlist($id)
    {
        Wishlist::find($id)->delete();
        return back();
    }
    function custom_login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back();
        } else {
            return back()->with('login_error', 'Your email or password is wrong');
        }
    }
    function get_color_list(Request $request)
    {
        $generated_options = "<option value=''>-Select One Color-</option>";
        $inventories = Inventory::where([
            'size_id' => $request->size_id,
            'product_id' => $request->product_id,
        ])->get();
        foreach ($inventories as $inventory) {
            $generated_options .= "<option value='" . $inventory->relationshiptocolor->id . "'>" . $inventory->relationshiptocolor->name . "(Stock:" . $inventory->quantity . ")</option>";
        }
        return $generated_options;
    }
    function add_to_cart(Request $request)
    {
        $real_stock = Inventory::where([
            'product_id' => $request->d_product_id,
            'size_id' => $request->d_size_id,
            'color_id' => $request->d_color_id,
        ])->first()->quantity;
        if ($request->user_quantity <= 0) {
            echo "bad number";
        } else {
            if ($real_stock < $request->user_quantity) {
                echo "Add to cart not possible";
            } else {
                if (Cart::where('user_id', auth()->id())->exists()) {
                    $cart_existing_product_vendor_id = Cart::where('user_id', auth()->id())->first()->relationshiptoproduct->user_id;
                    if ($cart_existing_product_vendor_id != Product::find($request->d_product_id)->user_id) {
                        Cart::where('user_id', auth()->id())->delete();
                    }
                }
                //now you can add this product to the cart - start
                //check if exists
                if (Cart::where([
                    'user_id' => auth()->id(),
                    'product_id' => $request->d_product_id,
                    'size_id' => $request->d_size_id,
                    'color_id' => $request->d_color_id
                ])->exists()) {
                    Cart::where([
                        'user_id' => auth()->id(),
                        'product_id' => $request->d_product_id,
                        'size_id' => $request->d_size_id,
                        'color_id' => $request->d_color_id
                    ])->increment('amount', $request->user_quantity);
                } else {
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
            if (Coupon::where('coupon_name', $coupon_name)->exists()) {
                if (Carbon::now() > Carbon::parse($coupon->coupon_validity)) {
                    return redirect('cart')->with('error', 'Coupon Date Expired');
                } else {
                    if ($coupon->coupon_limit == 0) {
                        return redirect('cart')->with('error', 'This coupon limit has exceeded');
                    } else {
                        $discount = $coupon->coupon_discount;
                        return view('cart', compact('discount', 'coupon_name'));
                    }
                }
            } else {
                return redirect('cart')->with('error', 'This coupon does not exists');
            }
        } else {
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
        if (strpos(url()->previous(), "cart") || strpos(url()->previous(), "checkout")) {
            $addresses = Address::where('user_id', auth()->id())->get();
            return view('checkout', compact('addresses'));
        } else {
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
    function checkout_final(Request $request)
    {
        // return session('s_coupon_name');
        // return session('s_coupon_discount_percent');
        // return session('s_coupon_discount_amount');
        // return session('s_subtotal');
        // return session('s_total');
        // return auth()->id();

        $invoice_no = Carbon::now()->format('Y') . "-" . Carbon::now()->format('m') . "-" . Str::upper(Str::random(5));

        if ($request->delivery_option == 1) {
            $delivery_charge = 60;
        } else {
            $delivery_charge = 120;
        }
        if ($request->payment_option == 'cod') {
            // insert into invoice table start
            $invoice_id = Invoice::insertGetId([
                'invoice_no' => $invoice_no,
                'user_id' => auth()->id(),
                'address_id' => $request->address_id,
                'coupon_name' => session('s_coupon_name'),
                'coupon_discount_percent' => session('s_coupon_discount_percent'),
                'coupon_discount_amount' => session('s_coupon_discount_amount'),
                'subtotal' => session('s_subtotal'),
                'total' => session('s_total'),
                'delivery_option' => $request->delivery_option,
                'delivery_charge' => $delivery_charge,
                'payment_option' => $request->payment_option,
                'created_at' => Carbon::now()
            ]);
            // insert into invoice table end

            //if coupon used then minus 1 start
            if (session('s_coupon_name')) {
                Coupon::where('coupon_name', session('s_coupon_name'))->decrement('coupon_limit');
            }
            //if coupon used then minus 1 end
            // store all products information to the invoice_details table start
            foreach (carts() as $cart) {
                Invoice_detail::insert([
                    'invoice_id' => $invoice_id,
                    'user_id' => $cart->user_id,
                    'product_id' => $cart->product_id,
                    'size_id' => $cart->size_id,
                    'color_id' => $cart->color_id,
                    'amount' => $cart->amount,
                    'purchase_price' => Product::find($cart->product_id)->discounted_price,
                    'created_at' => Carbon::now()
                ]);
                // decrement from inventory start
                Inventory::where([
                    'product_id' => $cart->product_id,
                    'size_id' => $cart->size_id,
                    'color_id' => $cart->color_id
                ])->decrement('quantity', $cart->amount);
                // decrement from inventory end

                //cart remove start
                $cart->delete();
                //cart remove end
            }
            // store all products information to the invoice_details table end
            // session value clear start
            session()->forget('s_coupon_name');
            session()->forget('s_coupon_discount_percent');
            session()->forget('s_coupon_discount_amount');
            session()->forget('s_subtotal');
            session()->forget('s_total');
            // session value clear end
            return redirect('cart')->with('success', 'Your Order Submitted as Cash on Delivery successfully!');
        } else {
            // insert into invoice table start
            $invoice_id = Invoice::insertGetId([
                'invoice_no' => $invoice_no,
                'user_id' => auth()->id(),
                'address_id' => $request->address_id,
                'coupon_name' => session('s_coupon_name'),
                'coupon_discount_percent' => session('s_coupon_discount_percent'),
                'coupon_discount_amount' => session('s_coupon_discount_amount'),
                'subtotal' => session('s_subtotal'),
                'total' => session('s_total'),
                'delivery_option' => $request->delivery_option,
                'delivery_charge' => $delivery_charge,
                'payment_option' => $request->payment_option,
                'created_at' => Carbon::now()
            ]);
            // insert into invoice table end
            //if coupon used then minus 1 start
            if (session('s_coupon_name')) {
                Coupon::where('coupon_name', session('s_coupon_name'))->decrement('coupon_limit');
            }
            //if coupon used then minus 1 end
            // store all products information to the invoice_details table start
            foreach (carts() as $cart) {
                Invoice_detail::insert([
                    'invoice_id' => $invoice_id,
                    'user_id' => $cart->user_id,
                    'product_id' => $cart->product_id,
                    'size_id' => $cart->size_id,
                    'color_id' => $cart->color_id,
                    'amount' => $cart->amount,
                    'purchase_price' => Product::find($cart->product_id)->discounted_price,
                    'created_at' => Carbon::now()
                ]);
                // decrement from inventory start
                Inventory::where([
                    'product_id' => $cart->product_id,
                    'size_id' => $cart->size_id,
                    'color_id' => $cart->color_id
                ])->decrement('quantity', $cart->amount);
                // decrement from inventory end

                //cart remove start
                $cart->delete();
                //cart remove end
            }
            // store all products information to the invoice_details table end
            session(['s_invoice_id' => $invoice_id]);
            return redirect('pay');
        }
    }

    public function search(Request $request)
    {
        $searched_products = Product::where('name', 'like', "%$request->q%")->get();
        return view('search', compact('searched_products'));
    }
}
