<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

use \stdClass;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'トークンが提供されていない。', 'status' => 401]);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::find($decoded->user_id);

            if (!$user) {
                return response()->json(['error' => 'ユーザーが見つかりません。', 'status' => 404]);
            }

            $request->user = $user;
        } catch (\Exception $e) {
            return response()->json(['error' => '無効なトークンです。', 'status' => 401]);
        }

        return $next($request);
    }
}
