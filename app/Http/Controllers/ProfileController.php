<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backend.profile.index');
    }
    public function change_password(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'password' => ['confirmed', Password::min(6)->letters()->numbers()]
        ]);

        if(Hash::check($request->current_password, auth()->user()->password)){
            User::find(auth()->id())->update([
                'password' => Hash::make($request->password)
            ]);
            return back()->withSuccess('New Password set successfully!');
        }else{
            return back()->withErrors('Current Password Does not Matched!');
        }
    }
    public function change_information(Request $request)
    {
        if($request->hasFile('profile_photo')){
            if(auth()->user()->profile_photo){
                unlink(public_path('uploads/profile_photos/') . auth()->user()->profile_photo);
            }
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
                User::find(auth()->id())->update([
                    'profile_photo' => $new_name
                ]);
            //database update end
        }

        User::find(auth()->id())->update([
            'name' => $request->name
        ]);
        return back()->with('information_success', 'Information Updated Successfully!');
    }
}
