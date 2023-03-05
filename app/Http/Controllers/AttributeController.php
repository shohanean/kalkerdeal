<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Carbon\Carbon;
use App\Models\Size;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    function add_attribute(){
        $sizes = Size::all();
        $colors = Color::all();
        return view('backend.attribute.add_attribute', compact('sizes', 'colors'));
    }
    function insert_size(Request $request){
        $request->validate([
            'name' => 'required|unique:sizes,name'
        ]);
        Size::insert([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);
        return back()->with('success', 'Size Added Successfully!');
    }
    function insert_color(Request $request){
        Color::insert([
            'name' => $request->name,
            'code' => $request->code,
            'created_at' => Carbon::now()
        ]);
        return back();
    }
}
