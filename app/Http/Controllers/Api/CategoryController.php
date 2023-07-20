<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'iserror' => false,
            'data' => Category::all(),
            'message' => 'All Category List',
            'errors' => []
        ]);
    }
    public function store(Request $request)
    {
        $validateCategory = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:20|unique:categories,name',
                'description' => 'required',
                'category_thumbnail' => 'image'
            ]
        );
        if ($validateCategory->fails()) {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'Validation Error',
                'errors' => $validateCategory->errors()
            ]);
        }
        $slug = Str::slug($request->name);
        $category_id = Category::insertGetId($request->except('_token', 'category_thumbnail') + [
            'slug' => $slug,
            'created_at' => Carbon::now()
        ]);
        if ($request->hasFile('category_thumbnail')) {
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
            $category = Category::find($category_id);
            $category->category_thumbnail = $new_name;
            $category->save();
            //database update end
            return response()->json([
                'iserror' => false,
                'data' => $category,
                'message' => 'Category added successfully!',
                'errors' => []
            ]);
        }
    }
    public function show($id)
    {
        if (Category::where('id', $id)->exists()) {
            return response()->json([
                'iserror' => false,
                'data' => Category::find($id),
                'message' => 'Get a Single Category',
                'errors' => []
            ]);
        } else {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'The category you are looking for is not there!',
                'errors' => ['message' => ['The category you are looking for is not there!']]
            ]);
        }
    }
    public function destroy($id)
    {
        if (Category::where('id', $id)->exists()) {
            return response()->json([
                'iserror' => false,
                'data' => Category::find($id)->delete(),
                'message' => 'Single Category Deleted successfully!',
                'errors' => []
            ]);
        } else {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'The category you are looking for is not there!',
                'errors' => ['message' => ['The category you are looking for is not there!']]
            ]);
        }
    }
}
