<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        try {
            if (!$validator->fails()) {

                //
                $data = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env("GOOGLE_RECAPTCHA_SECRET"),
                    'response' => $request->input('recaptcha_token'),
                ])->json();

                if ($data['success'] == true) {
                    $user = User::create([
                        'name' => $request->input('name'),
                        'email'    => $request->input('email'),
                        'password' => $request->input('password'),
                    ]);
                    $token = auth('user')->login($user);

                    return $this->respondWithToken($token);
                } else {
                    return Response()->json(['error_msg' => "access Denied"]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ]);
        }
    }



    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'name' => auth('user')->user()->name,
            'id' => auth('user')->user()->id,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('user')->factory()->getTTL() * 60,
            'role' => 'Costumer'

        ]);
    }
}
