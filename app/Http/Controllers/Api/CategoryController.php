<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
