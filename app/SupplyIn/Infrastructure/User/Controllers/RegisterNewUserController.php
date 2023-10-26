<?php

namespace App\SupplyIn\Infrastructure\User\Controllers;

use App\Http\Controllers\Controller;
use App\SupplyIn\Application\User\UseCases\RegisterNewUserUseCase;
use App\SupplyIn\Domain\User\Exceptions\ErrorInRegisterNewUserException;
use App\SupplyIn\Infrastructure\User\RequestResources\RegisterNewUserRequestResource;
use App\SupplyIn\Infrastructure\User\Requests\RegisterNewUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterNewUserController extends Controller
{
    public function __construct(
        private RegisterNewUserUseCase $registerNewUserUseCase,
    )
    {
    }

    /**
     * @throws ErrorInRegisterNewUserException
     */
    public function __invoke(RegisterNewUserRequest $request):JsonResponse
    {
        $requestResource = new RegisterNewUserRequestResource(
            NULL,
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->get('role'),
        );

        return new JsonResponse($this->registerNewUserUseCase->execute($requestResource));
    }
}
