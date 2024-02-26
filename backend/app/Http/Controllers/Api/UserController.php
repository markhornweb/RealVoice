<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request) {
        $validator = Validator::make(request()->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users',
            'old_password' => 'nullable|string|min:8',
            'new_password' => $request->filled('old_password') ? 'required|string|min:8' : 'nullable|string|min:8',
            'confirm_password' => $request->filled('new_password') ? 'required|string|same:new_password' : 'nullable|string',
            'birthday' => 'nullable|date',
            'description' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user;

        $allEmptyOrNull = true;
        foreach ($request->all() as $value) {
            if (!empty($value) && $value !== null) {
                $allEmptyOrNull = false;
                break;
            }
        }

        if ($allEmptyOrNull) {
            return response()->json([
                'errors' => '対応する値が入力されませんでした。',
                'status' => 401,
            ], Response::HTTP_BAD_REQUEST);
        }

        if($request->filled('name')) {
            $user->name = $request->name;
            $user->save();

            return response()->json([
                'message' => 'ユーザー名が成果的に変更されました。',
                'status' => 200
            ]);
        } else if($request->filled('description')) {
            $user->description = $request->description;
            $user->save();

            return response()->json([
                'message' => '簡単な自己紹介を正確に更新しました。',
                'status' => 200
            ]);
        } else if($request->filled('birthday')) {
            if (Carbon::parse($request->birthday)->diffInYears(Carbon::now()) < 18) {
                return response()->json([
                    'error' => '18歳未満の誕生年月日は許可されません。',
                    'status' => 401,
                ], Response::HTTP_BAD_REQUEST);
            }
            $user->birthday = $request->birthday;
            $user->save();
            
            return response()->json([
                'message' => '生年月日が成果的に変更されました。',
                'status' => 200
            ]);
        } else if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'error' => '旧パスワードが正しくありません。',
                    'status' => 401,
                ], Response::HTTP_BAD_REQUEST);
            }

            $user->password = bcrypt($request->new_password);
            $user->save();
    
            return response()->json([
                'message' => 'パスワードが正常に変更されました。',
                'status' => 200
            ]);
        } else if ($request->filled('email')) {
            $user->remember_verify_code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $user->save();
            // Here, you should send this code to user's email or phone_number
            return response()->json([
                'message' => '認証コードは正常に送信されました。',
                'status' => 200
            ]);
        } else if($request->filled('phone_number')) {
            $user->remember_verify_code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $user->save();
            // For demonstration purpose, let's just return the code
            return response()->json([
                'message' => '認証コードは正常に送信されました。',
                'status' => 200
            ]);
        }
    }
}
