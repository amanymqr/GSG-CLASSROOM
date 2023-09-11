<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use DragonCode\Contracts\Cashier\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokensController extends Controller
{
    public function index(Request $request)
    {
        return $request->user('sunctam')->user()->tokens;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required|email'],
            'password' => ['required'],
            'device_name' => ['sometimes', 'required'],
            'abilities' => ['array'],

        ]);

        Auth::guard('sanctum')->attempt([
            'email'
        ]);
        $user = User::whereEmail($request->email);
        if ($user && Hash::check($request->password, $user->password)) {
            $name = $request->post('device_name', $request->userAgent());
            $abilities = $request->post('abilities', ['*']);
            $token = $user->createToken('name', $abilities, now()->addDays(90));
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }
        return response()->json([
            'message' => __('Invalid credentials')
        ], 401);
    }

    public function destroy($id = null)
    {
        $user = Auth::guard('sanctum')->user();
        //Revoke(logout from current device)
        if ($id) {
            if ($id == 'current') {
                $user->currentAccessToken()->delete();
            } else {
                $user->tokens()->findOrFail($id)->delete();
            }
        }else{
            $user->tokens()->delete();
        }
    }
}
