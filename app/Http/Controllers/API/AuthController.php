<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'nohp' => ['required'],
                'password' => ['required', 'string'],
            ]);

            $email = User::where('email', $request->email)->first();
            $nohp = User::where('nohp', $request->nohp)->first();

            if ($email) {
                return ResponseFormatter::error([
                    'message' => 'email already exists',
                ], 'Authentication Failed', 401);
            }
            if ($nohp) {
                return ResponseFormatter::error([
                    'message' => 'phone already exists',
                ], 'Authentication Failed', 401);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nohp' => $request->nohp,
                'role' => 'USER',
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            DB::commit();
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'User Registered');
        } catch (Exception $error) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => 'Shometing went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);


            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                return ResponseFormatter::error([
                    'message' => 'email is not registered',
                ], 'Authentication Failed', 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'password incorrect',
                ], 'Authentication Failed', 401);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'alamat' => ['required', 'string'],
            'nohp' => ['nullable', 'string', 'max:255', 'unique:users,nohp,' . $user->id],
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($user->image != null) {
                    // Hapus Foto
                    unlink(public_path($user->image));
                }
                $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $path = $request->file('image')->storeAs('public/uploads/profile', $fileName);
                $url = 'storage/uploads/profile/' . $fileName;
                $user->image = $url;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->alamat = $request->alamat;
            $user->nohp = $request->nohp;
            $user->save();

            DB::commit();
            return ResponseFormatter::success([
                'user' => new UserResource($user),
            ], 'Success');
        } catch (Exception $error) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 500);
        }

        return ResponseFormatter::success($user, 'Profile updated');
    }



    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        try {
            $request->validate([
                'password' => 'required',
                'new_password' => 'required'
            ]);

            $user = User::where('email', $user->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credential');
            }

            $data['password'] = Hash::make($request->new_password);
            $user->update($data);

            return ResponseFormatter::success([
                // 'user' => $user,
                'message' => 'Password has changed',
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Password Salah',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function user()
    {
        $users = Auth::user();

        return ResponseFormatter::success([
            'user' =>  new UserResource($users),
        ], 'Authenticated');
    }
}
