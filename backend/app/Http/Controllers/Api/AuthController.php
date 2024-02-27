<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_verify_code' => $verificationCode,
        ]);

        $token = JWT::encode(['user_id' => $user->id], env('JWT_SECRET'), 'HS256');

        return response()->json(['token' => $token, 'message' => '成果的に登録されました。', 'status' => 201]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $validatedData = $validator->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'メールアドレスが登録されていません。', 'status' => 404]);
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'パスワードが正しくありません。', 'status' => 401]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->token = JWT::encode(['user_id' => $user->id], env('JWT_SECRET'), 'HS256');
            $user->is_active = 1;
            return response()->json([
                'message' => 'ユーザーログインに成功しました。',
                'data'    => $user,
                'status' => 201
            ]);
        } else {
            return response()->json(['error' => 'ユーザーログインに失敗しました。', 'status' => 401]);
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'verification_code' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = $request->verification_code;

        $user = $request->user;

        if($verificationCode != $user->remember_verify_code) {
            return response()->json(['error' => '認証コードが一致しません。', 'status' => 401]);
        }

        $user->remember_verify_code = "";
        $user->email_verified_at = now();
        $user->is_active = 1;
        $user->save();

        return response()->json(['message' => '検証は成功しました。', 'status' => 201]);
    }
}
