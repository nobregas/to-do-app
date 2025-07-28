<?php

namespace App\Services\Interface;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(LoginRequest $request): array;

    public function register(RegisterRequest $request): RegisterResource;

    public function logout(User $user): void;

    public function verifyTwoFactorCode(User $user, string $code): array;

    public function forgotPassword(Request $request): JsonResponse;
}
