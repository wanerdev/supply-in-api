<?php

namespace Tests\Unit\User\UseCases;

use App\SupplyIn\Application\User\UseCases\RegisterNewUserUseCase;
use App\SupplyIn\Domain\User\Eloquent\UserEloquent;
use App\SupplyIn\Domain\User\Mapper\UserMapper;
use App\SupplyIn\Infrastructure\User\RequestResources\RegisterNewUserRequestResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\TestCase;

class RegisterNewUserUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUser()
    {
        //No funciona
        // Crea un mock de UserMapper
        $userMapper = Mockery::mock('App\SupplyIn\Domain\User\Mapper\UserMapper');

        // Crea una instancia real de UserEloquent con datos simulados
        $expectedUserEloquent = new UserEloquent(); // Importante: no es un mock
        $expectedUserEloquent->id = 1; // ID simulado
        $expectedUserEloquent->name = 'Nombre de usuario';
        $expectedUserEloquent->email = 'correo@ejemplo.com';
        $expectedUserEloquent->password = 'hashed_password'; // Contraseña hasheada simulada
        $expectedUserEloquent->role = 'rol';

        // Configura el mock de UserMapper para devolver la instancia real de UserEloquent
        $userMapper->shouldReceive('fromEntityToEloquent')->andReturn($expectedUserEloquent);

        // Crea una instancia del caso de uso con el mock de UserMapper
        $useCase = new RegisterNewUserUseCase($userMapper);

        // Crea una instancia de RegisterNewUserRequestResource con datos simulados
        $requestResource = new RegisterNewUserRequestResource(
            null, // ID válido si es necesario
            'Nombre de usuario',
            'correo@ejemplo.com',
            'contraseña_segura',
            'rol'
        );

        // Ejecuta el caso de uso
        $result = $useCase->execute($requestResource);

        // Realiza aserciones sobre el resultado
        $this->assertEquals(100, $result['status']);
        $this->assertEquals('Correct new User insertion !', $result['message']);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertEquals('Bearer', $result['token_type']);

        // Verifica que se haya llamado al método fromEntityToEloquent en UserMapper
        $userMapper->shouldHaveReceived('fromEntityToEloquent')->once();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
