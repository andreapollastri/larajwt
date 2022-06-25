<?php

namespace Andr3a\Larajwt\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Andr3a\Larajwt\Models\Token;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;

class JwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        $token = null;

        if (Str::startsWith($auth, 'Bearer ')) {
            $token = Str::substr($auth, 7);
        }

        if (! $token) {
            return response()->json([
                'message' => 'Authorization header missed in payload.',
                'errors' => 'Missing Authorization.',
            ], 422);
        }

        if ($token) {
            try {
                $request->jwt = JWT::decode($token, config('larajwt.jwt_access_secret'), ['HS256']);
            } catch (ExpiredException $e) {
                return response()->json([
                    'message' => 'Given token is expired.',
                    'errors' => 'Expired token.',
                ], 401);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Given token is invalid.',
                    'errors' => 'Invalid token.',
                ], 401);
            }
        }

        if (config('larajwt.jwt_session_db_check')) {
            $session = Token::where('payload', $request->jwt->token_id)->first();
            if (! $session) {
                return response()->json([
                    'message' => 'Given token is expired.',
                    'errors' => 'Expired token.',
                ], 401);
            }
        }

        $request->user = Auth::loginUsingId($request->jwt->user_id);

        return $next($request);
    }
}
