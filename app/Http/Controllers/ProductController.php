<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Featured_photo;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->latest()->get();
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_featured_photos.*' => 'required|image'
        ]);
        if ($request->discount) {
            $discount = $request->discount;
            $discounted_price = $request->regular_price - ($request->regular_price * ($request->discount / 100));
        } else {
            $discount = 0;
            $discounted_price = $request->regular_price;
        }

        $product_id = Product::insertGetId([
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'purchase_manufacturing_price' => $request->purchase_manufacturing_price,
            'regular_price' => $request->regular_price,
            'discount' => $discount,
            'discounted_price' => $discounted_price,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_information' => $request->additional_information,
            'care_instructions' => $request->care_instructions,
            'product_thumbnail' => "PHOTO",
            'created_at' => Carbon::now()
        ]);
        //photo upload start

        $new_name = Str::lower(Str::random(20)) . "." . $request->file('product_thumbnail')->extension();
        $photo_path = 'uploads/product_thumbnails/' . $new_name;

        Image::make($request->file('product_thumbnail'))->text('Kalkerdeal', 10, 20, function ($font) {
            $font->size(500);
            $font->color([255, 255, 255, 1]);
            $font->align('center');
            $font->valign('top');
            $font->angle(45);
        })->resize(192, 160)->save($photo_path);

        //photo upload end
        //database update start
        Product::find($product_id)->update([
            'product_thumbnail' => $new_name
        ]);
        //database update end

        //featured photo upload starts
        foreach ($request->product_featured_photos as $product_featured_photo) {
            $new_name = $product_id . "-" . Str::lower(Str::random(20)) . "." . $product_featured_photo->extension();
            $photo_path = 'uploads/product_featured_photos/' . $new_name;

            Image::make($product_featured_photo)->text('Kalkerdeal', 10, 20, function ($font) {
                $font->size(500);
                $font->color([255, 255, 255, 1]);
                $font->align('center');
                $font->valign('top');
                $font->angle(45);
            })->resize(750, 750)->save($photo_path);

            Featured_photo::insert([
                'product_id' => $product_id,
                'featured_photo_name' => $new_name,
                'created_at' => Carbon::now()
            ]);
        }
        //featured photo upload ends
        return back()->withSuccess('Product Uploaded Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('backend.product.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('backend.product.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function add_inventory($id)
    {
        $product = Product::find($id);
        $sizes = Size::all();
        $colors = Color::all();
        $inventories = Inventory::where('product_id', $id)->with('relationshiptosize', 'relationshiptocolor')->get();
        return view('backend.product.add_inventory', compact('product', 'sizes', 'colors', 'inventories'));
    }
    public function insert_inventory($id, Request $request)
    {
        if (Inventory::where([
            'product_id' => $id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
        ])->exists()) {

            Inventory::where([
                'product_id' => $id,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
            ])->increment('quantity', $request->quantity);
        } else {
            Inventory::insert([
                'product_id' => $id,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now()
            ]);
        }
        return back();
    }
}
