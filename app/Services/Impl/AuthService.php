<?php

namespace App\Services\Impl;

use App\Exceptions\exceptions\UnauthorizedException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Jobs\SendEmailJob;
use App\Mail\SendTwoFactorCode;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interface\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

readonly class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): RegisterResource
    {
        $user = $this->userRepository->create($request->validated());
        $token = $user->createToken('auth-token')->plainTextToken;

        Log::info('User registered successfully.', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);


        return new RegisterResource($user, $token);
    }

    public function login(LoginRequest $request): array
    {
        if (!Auth::attempt($request->validated())) {
            Log::warning('Failed login attempt.', [
                'email' => $request->email
            ]);

            throw new UnauthorizedException;
        }

        $user = Auth::user();

        if (!$user) {
            throw new UnauthorizedException;
        }

        // Generate and send 2FA code
        $code = $this->generateAndSendTwoFactorCode($user);

        Log::info('2FA code sent to user.', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return [
            'message' => 'Two-factor authentication code has been sent to your email.',
            'requires_2fa' => true
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();

        Log::info('User logged out.', [
            'user_id' => $user->id
        ]);
    }

    /**
     * Generate and send a 2FA code to the user's email
     */
    private function generateAndSendTwoFactorCode(User $user): string
    {
        // Generate a 6-digit code
        $code = strtoupper(Str::random(6, '0123456789'));
        
        // Store the code in cache for 10 minutes
        $cacheKey = '2fa_code_' . $user->id;
        Cache::put($cacheKey, [
            'code' => $code,
            'attempts' => 0,
            'verified' => false
        ], now()->addMinutes(10));

        // Send the code via email
        SendEmailJob::dispatch(
            new SendTwoFactorCode($code),
            $user->email
        )->onQueue('emails');

        return $code;
    }

    /**
     * Verify the 2FA code
     */
    public function verifyTwoFactorCode(User $user, string $code): array
    {
        $cacheKey = '2fa_code_' . $user->id;
        $cached = Cache::get($cacheKey);

        if (!$cached || $cached['code'] !== $code) {
            // Increment attempts if code exists but is wrong
            if ($cached) {
                $cached['attempts']++;
                Cache::put($cacheKey, $cached, now()->addMinutes(10));

                if ($cached['attempts'] >= 3) {
                    Cache::forget($cacheKey);
                    throw new UnauthorizedException('Too many attempts. Please request a new code.');
                }
            }
            
            throw new UnauthorizedException('Invalid verification code.');
        }

        // Mark as verified and generate auth token
        $cached['verified'] = true;
        Cache::put($cacheKey, $cached, now()->addMinutes(10));

        // Create auth token
        $token = $user->createToken('auth-token')->plainTextToken;

        Log::info('2FA verification successful', [
            'user_id' => $user->id
        ]);

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        // Implementation for forgot password
        return response()->json(['message' => 'Password reset link sent to your email']);
    }
}
