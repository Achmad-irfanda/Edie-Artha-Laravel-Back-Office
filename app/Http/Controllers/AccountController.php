<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function profile()
    {
        return view('account.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'nohp.required' => 'No Hp tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
        ]);

        $user = User::find(Auth::user()->id);

        // Update Photo Profile
        if ($request->hasFile('image')) {
            // Validate the uploaded file
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
            ]);
            // Hapus Photo Lama
            if ($user->image != null) {
                unlink(public_path($user->image));
            }

            // Upload Photo
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName =  time() . '.' . $extension;

            $request->file('image')->storeAs('public/uploads/profile', $fileName);
            $url = 'storage/uploads/profile/' . $fileName;
            $user->update([
                'image' => $url,
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('profile')->with('message', 'Your Profile Updated Succesfully');
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        // Update Password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->route('profile')->with('message', 'Your Password Updated Succesfully');;
    }
}
