<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    { //check AuthRequest.php

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            /**
             *  usually it's good to make an API resource to specify the data and shape it
             *  this is very commun, practice it
             *  php artisan make:resource UserResource
             *  it will become:
             *  return new UserResource($user);
             *  https://laravel.com/docs/10.x/eloquent-resources#introduction
             */


            'user_info' => $user
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],//don't forget the password rule ['required','password']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) { //use this Auth::attempt(['email' => $email, 'password' => $password)

            return response()->json(['error' => 'email or password is not correct'], 422);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json(['access_token' => $user->createtoken($device, ['Driver:update'])->plainTextToken]); //idk how  secure this is I always use laravel breeze and sanctum for auth
    }

    public function logout(User $user)
    {
        //logout example, u don't need $user
        //https://laravel.com/docs/10.x/authentication#logging-out

        $user->tokens()->delete();

        return response()->json([
            'details' => 'you are loged out ',
        ]);
    }
}
