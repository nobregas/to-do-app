<?php

namespace App\Services\Impl;

use App\Exceptions\exceptions\UnauthorizedException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interface\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

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

        return new RegisterResource($user, $token);
    }

    public function login(LoginRequest $request): LoginResource
    {
        if (!Auth::attempt($request->validated())) {
            throw new UnauthorizedException;
        }

        $user = Auth::user();

        if (!$user) {
            throw new UnauthorizedException;
        }

        $token =  $user->createToken('auth-token')->plainTextToken;

        return new LoginResource($user, $token);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
