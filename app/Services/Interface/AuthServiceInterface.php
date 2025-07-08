<?php

namespace App\Services\Interface;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;

interface AuthServiceInterface
{
    public function login(LoginRequest $request): LoginResource;

    public function register(RegisterRequest $request): RegisterResource;

    public function logout(User $user): void;

}
