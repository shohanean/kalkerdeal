<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    function index(){
        $categories = Category::latest()->get();
        return view('backend.category.index', compact('categories'));
    }
    function create(){
        return view('backend.category.create');
    }
    function insert(Request $request){
        //validation start
        $request->validate(
            [
                'name' => 'required|max:20|unique:categories,name',
                'description' => 'required',
                'category_thumbnail' => 'image'
            ],
            [
                'name.required' => 'নাম দিতে হবে',
                'name.max' => '20 charecter r beshi dewa jaibo na',
                'description.required' => 'বর্ননা দিতে হবে',
            ]
        );
        //validation end
        $slug = Str::slug($request->name);
        $category_id = Category::insertGetId($request->except('_token') + [
            'slug' => $slug,
            'created_at' => Carbon::now()
        ]);

        if($request->hasFile('category_thumbnail')){
            //photo upload start
                $new_name = Str::lower(Str::random(20)).".".$request->file('category_thumbnail')->extension();
                $photo_path = 'uploads/category_thumbnails/'. $new_name;

                Image::make($request->file('category_thumbnail'))->text('Kalkerdeal', 10, 20, function ($font) {
                    $font->size(500);
                    $font->color([255, 255, 255, 1]);
                    $font->align('center');
                    $font->valign('top');
                    $font->angle(45);
                })->save($photo_path);
            //photo upload end

            //database update start
            Category::find($category_id)->update([
                'category_thumbnail' => $new_name
            ]);
            //database update end
        }

        return back()->withSuccess('Category added successfully!');
    }

    function delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('delete_success', 'Category Deleted Successfully!');
    }
    function restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restore_success', 'Category Restored Successfully!');
    }
    function permanent_delete($category_id){
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back();
    }
    function update($category_id){
        $category = Category::find($category_id);
        return view('backend.category.update', compact('category'));
    }
    function edit(Request $request, $category_id){
        //image part start
        if($request->hasFile('category_thumbnail')){

            $category = Category::find($category_id);

            if($category->category_thumbnail != "defaultcategoryphoto.jpg"){
                unlink(public_path('uploads/category_thumbnails/') . $category->category_thumbnail);
            }

            //photo upload start
            $new_name = Str::lower(Str::random(20)) . "." . $request->file('category_thumbnail')->extension();
            $photo_path = 'uploads/category_thumbnails/' . $new_name;

            Image::make($request->file('category_thumbnail'))->text('Kalkerdeal', 10, 20, function ($font) {
                $font->size(500);
                $font->color([255, 255, 255, 1]);
                $font->align('center');
                $font->valign('top');
                $font->angle(45);
            })->save($photo_path);
            //photo upload end
            //database update start
            Category::find($category_id)->update([
                'category_thumbnail' => $new_name
            ]);
            //database update end
        }
        //image part end
        Category::find($category_id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect('category');
    }
    function restore_all(){
        Category::onlyTrashed()->restore();
        return back();
    }
    function permanent_delete_all(){
        Category::onlyTrashed()->forceDelete();
        return back();
    }
}
