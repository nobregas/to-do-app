<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="API To-Do List",
 * description="Documentação interativa da API para o gerenciador de tarefas.",
 * @OA\Contact(
 * email="seu-email@exemplo.com"
 * ),
 * @OA\License(
 * name="Apache 2.0",
 * url="http://www.apache.org/licenses/LICENSE-2.0.html"
 * )
 * )
 *
 * @OA\Server(
 * * url="http://localhost",
 * * description="Servidor de Desenvolvimento Local"
 * * )
 * @OA\Components(
 *  @OA\SecurityScheme(
 *  type="http",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerAuth"
 *  )
 *  )
 */
abstract class Controller
{
    //
}
