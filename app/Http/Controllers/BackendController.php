<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class BackendController extends Controller
{
    function dashboard(){
        //data binding ways (3)

        //way 1
        $categories = Category::latest()->get();
        $trashed_categories = Category::onlyTrashed()->get();
        $users = User::all();
        return view('backend.dashboard', compact('categories', 'trashed_categories', 'users'));

        //way 2
        // return view('backend.dashboard', [
        //     'categories' => Category::latest()->get()
        // ]);

        //way 3
        // $categories = Category::latest()->get();
        // return view('backend.dashboard')->with('categories', $categories);
    }
}
