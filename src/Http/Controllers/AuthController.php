<?php

namespace Geekpack\Gauth\Http\Controllers;

use Geekpack\Gauth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Event;
use Geekpack\Gauth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    protected $timeRefreshToken;

    public function __construct()
    {
        $this->timeRefreshToken = (float)env('TIME_REFRESH_TOKEN', 60);
    }

    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid login details'], 401);
            }
            return response()->json(['message' => 'Invalid login details.'], 403);
        }
    
        $user = User::where('email', $request['email'])->firstOrFail();
    
        if (!$user->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email not verified.'], 403);
            }
            return response()->json(['message' => 'Email not verified.'], 403);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
        
        $currentDateTime = \Carbon\Carbon::now();
        $expirationTime = $currentDateTime->addMinutes($this->timeRefreshToken);

        // Obtener roles y permisos del usuario
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');
        
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user, 'roles' => $roles, 'permissions' => $permissions, 'time_expire' => $expirationTime, 'time_expire_second' => $this->takeExpireTimeToken()], 200);
    }

    public function showRegister()
    {
        return Inertia::render('Auth/Register');
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol predeterminado al usuario
        $user->assignRole('user');

        Event::dispatch(new Registered($user));

        return response()->json(['message' => 'Registration successful. Please check your email to verify your account.'], 201);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to logout.'], 500);
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function showForgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'We can\'t find a user with that email address.'], 404);
        }

        $token = \Str::random(60);

        $status = \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => \Carbon\Carbon::now()
            ]
        );

        $result = $user->sendPasswordResetNotification($token);

        if ($status == $result) {
            return response()->json(['message' => 'Password reset link sent'], 200);
        } 

        return response()->json(['message' => 'Unable to send password reset link'], 500);
    }

    public function showResetPassword(Request $request)
    {
        return Inertia::render('Auth/ResetPassword');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $status = \DB::table('password_reset_tokens')->where('token', $request->token)->first();
        
        if($status){
            $user = User::where('email', $status->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            \DB::table('password_reset_tokens')->where('token', $request->token)->delete();
            
            return response()->json(['message' => 'Password has been reset'], 200);
        }

        return response()->json(['message' => 'Unable to reset password'], 500);
    }

    public function emailVerificationNotice()
    {
        return response()->json(['message' => 'Email verification required'], 403);
    }

    public function showVerifyEmail(Request $request)
    {
        $user = User::findOrFail($request->route('id'));
        return Inertia::render('Auth/VerifyEmail', [
            'verifyurl' => '/api/email/verify/'.$request->route('id').'/'.sha1($user->email),
        ]);
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email has been verified.'], 200);
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email resent.'], 200);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);
        $user = $request->user();

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        $currentDateTime = \Carbon\Carbon::now();
        $expirationTime = $currentDateTime->addMinutes($this->timeRefreshToken);

        return response()->json(['access_token' => $token, 'time_expire' => $expirationTime, 'time_expire_second' => $this->takeExpireTimeToken()]);
    }

    public function takeExpireTimeToken() {
        $fechaInicio = \Carbon\Carbon::now();
        $fechaFin = \Carbon\Carbon::now()->addMinutes($this->timeRefreshToken);
    
        // Asegúrate de que ambas fechas estén en la misma zona horaria
        $fechaInicio->setTimezone('UTC');
        $fechaFin->setTimezone('UTC');
    
        // Calcula la diferencia en segundos y asegúrate de que sea positiva
        $diferenciaEnSegundos = $fechaFin->diffInSeconds($fechaInicio, false); // El parámetro false permite diferencias negativas
        return intval(abs($diferenciaEnSegundos)); // Devuelve el valor absoluto como entero
    }
}
