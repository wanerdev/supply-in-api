<?php

namespace Tests\Unit\User\Controller;

use App\SupplyIn\Application\User\UseCases\RegisterNewUserUseCase;
use App\SupplyIn\Infrastructure\User\Controllers\RegisterNewUserController;
use App\SupplyIn\Infrastructure\User\Requests\RegisterNewUserRequest;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class RegisterNewUserControllerTest extends TestCase
{
    public function testRegisterNewUser()
    {
        // Crear un objeto simulado (mock) de RegisterNewUserUseCase
        $registerNewUserUseCase = $this->createMock(RegisterNewUserUseCase::class);

        // Crear un objeto RegisterNewUserRequest con valores válidos
        $request = new RegisterNewUserRequest([
            'name' => 'Nombre de usuario válido',
            'email' => 'correo@ejemplo.com',
            'password' => 'contraseña_segura',
            'role' => 'rol',
        ]);

        // Configurar el comportamiento esperado del mock de RegisterNewUserUseCase
        $registerNewUserUseCase->expects($this->once())
            ->method('execute')
            ->willReturn(['success' => true]);

        // Crear una instancia del controlador con la dependencia simulada
        $controller = new RegisterNewUserController($registerNewUserUseCase);

        // Llamar al método __invoke del controlador con la solicitud simulada
        $response = $controller->__invoke($request);

        // Verificar que se devuelva una instancia de JsonResponse y que contenga el contenido esperado
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['success' => true], json_decode($response->getContent(), true));
    }
}
