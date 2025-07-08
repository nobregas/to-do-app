<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Services\Interface\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="registerUser",
     * tags={"Autenticação"},
     * summary="Registra um novo usuário",
     * description="Cria um novo usuário e retorna um token de acesso.",
     * @OA\RequestBody(
     * required=true,
     * description="Dados do novo usuário",
     * @OA\JsonContent(
     * required={"name","email","password","password_confirmation"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     * ),
     * ),
     * @OA\Response(
     * response=201,
     * description="Usuário registrado com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/LoginSuccessResource")
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação"
     * )
     * )
     */
    public function register(RegisterRequest $request):  RegisterResource
    {
        return $this->authService->register($request);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="loginUser",
     * tags={"Autenticação"},
     * summary="Autentica um usuário",
     * description="Autentica um usuário com email e senha e retorna um token de acesso.",
     * @OA\RequestBody(
     * required=true,
     * description="Credenciais de acesso",
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123")
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Login bem-sucedido",
     * @OA\JsonContent(ref="#/components/schemas/LoginSuccessResource")
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação ou credenciais inválidas"
     * )
     * )
     */
    public function login(LoginRequest $request):  LoginResource
    {
        return $this->authService->login($request);
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * operationId="logoutUser",
     * tags={"Autenticação"},
     * summary="Desconecta o usuário autenticado",
     * description="Invalida o token de acesso atual do usuário.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Logout bem-sucedido",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Logged out")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Não autorizado"
     * )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            "message" => "Logged out"
        ]);
    }
}
