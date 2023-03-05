<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreation;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('backend.user.index', compact('users'));
    }
    public function create()
    {
        return view('backend.user.create');
    }
    public function insert(Request $request)
    {
        $generated_password = Str::upper(Str::random(8));
        $user_id = User::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($generated_password),
            'created_at' => Carbon::now(),
            'role' => $request->role
        ]);

        if($request->hasFile('profile_photo')){
            //photo upload start
            $new_name = Str::lower(Str::random(20)) . "." . $request->file('profile_photo')->extension();
            $photo_path = 'uploads/profile_photos/' . $new_name;

            Image::make($request->file('profile_photo'))->text('Kalkerdeal', 10, 20, function ($font) {
                $font->size(500);
                $font->color([255, 255, 255, 1]);
                $font->align('center');
                $font->valign('top');
                $font->angle(45);
            })->save($photo_path);
            //photo upload end

            //database update start
            User::find($user_id)->update([
                'profile_photo' => $new_name
            ]);
            //database update end
        }

        // email send start
        $info = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $generated_password,
            'role' => $request->role
        ];
        Mail::to($request->email)->send(new AccountCreation($info));
        // email send end
        return back();
    }
}
