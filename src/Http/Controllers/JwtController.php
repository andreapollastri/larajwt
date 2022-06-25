<?php

namespace Andr3a\Larajwt\Http\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Andr3a\Larajwt\Models\Token;
use Firebase\JWT\ExpiredException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JwtController extends Controller
{
    public function login(Request $request)
    {
        if (! $request->username || ! $request->password) {
            return response()->json([
                'message' => 'Missing parameters.',
                'errors' => 'Missing username and/or password parameters.',
            ], 422);
        }

        Auth::attempt([
            'email' => $request->username,
            'password' => $request->password,
        ]);

        if (! Auth::check()) {
            return response()->json([
                'message' => 'Given credentials are invalid.',
                'errors' => 'Username and password don\'t match.',
            ], 401);
        }

        $session = Token::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'last_activity' => time(),
            'payload' => JWT::encode([
                'iat' => time(),
                'exp' => time() + config('larajwt.jwt_refresh_ttl'),
            ], config('larajwt.jwt_refresh_secret')),
        ]);

        return response()->json([
            'access_token' => JWT::encode([
                'user_id' => Auth::user()->id,
                'token_id' => $session->id,
                'iat' => time(),
                'exp' => time() + config('larajwt.jwt_access_ttl'),
            ], config('larajwt.jwt_access_secret')),
            'refresh_token' => $session->payload,
            'expires_in' => config('larajwt.jwt_access_ttl'),
            'token_type' => 'bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user;
    }

    public function refresh(Request $request)
    {
        if (! $request->refresh_token) {
            return response()->json([
                'message' => 'Missing parameters.',
                'errors' => 'Missing refresh_token parameter.',
            ], 422);
        }

        $session = Token::where('payload', $request->refresh_token)->first();

        if ($session) {
            try {
                JWT::decode($session->payload, config('larajwt.jwt_refresh_secret'), ['HS256']);
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

            $session->payload = JWT::encode([
                'iat' => time(),
                'exp' => time() + config('larajwt.jwt_refresh_ttl'),
            ], config('larajwt.jwt_refresh_secret'));
            $session->last_activity = time();
            $session->save();

            return response()->json([
                'access_token' => JWT::encode([
                    'user_id' => $session->user_id,
                    'token_id' => $session->id,
                    'iat' => time(),
                    'exp' => time() + config('larajwt.jwt_access_ttl'),
                ], config('larajwt.jwt_access_secret')),
                'refresh_token' => $session->payload,
                'expires_in' => config('larajwt.jwt_access_ttl'),
                'token_type' => 'bearer',
            ]);
        } else {
            return response()->json([
                'message' => 'Given token is invalid.',
                'errors' => 'Invalid token.',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $session = Token::find($request->jwt->token_id);

        if ($session) {
            $session->delete();
        }
    }
}
