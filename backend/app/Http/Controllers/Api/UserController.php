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
            'phone_number' => ['nullable', 'string', 'regex:/^0\d{2}-\d{3,4}-\d{4}$/'],
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

    public function profileEmailUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|min:4|max:4',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user;

        if ($user->remember_verify_code === $request->verification_code) {
            $user->email = $request->email;
            $user->remember_verify_code = "";
            $user->save();

            return response()->json([
                'message' => 'メールが正確に更新されました。',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => '確認コードが正しくありません。',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function profilePhoneUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|min:4|max:4',
            'phone_number' => ['required', 'string', 'regex:/^0\d{2}-\d{3,4}-\d{4}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user;

        if ($user->remember_verify_code === $request->verification_code) {
            $user->phone_number = $request->phone_number;
            $user->remember_verify_code = "";
            $user->save();

            return response()->json([
                'message' => '電話番号が正確に更新されました。',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => '確認コードが正しくありません。',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
