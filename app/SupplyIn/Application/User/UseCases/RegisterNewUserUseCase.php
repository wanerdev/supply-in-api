<?php

namespace App\SupplyIn\Application\User\UseCases;

use App\SupplyIn\Domain\User\Entity\User;
use App\SupplyIn\Domain\User\Exceptions\ErrorInRegisterNewUserException;
use App\SupplyIn\Domain\User\Mapper\UserMapper;
use App\SupplyIn\Infrastructure\User\RequestResources\RegisterNewUserRequestResource;

class RegisterNewUserUseCase
{
    public function __construct(
        private UserMapper $userMapper,
    )
    {
    }

    /**
     * @throws ErrorInRegisterNewUserException
     */
    public function execute(RegisterNewUserRequestResource $requestResource): array
    {
        $newUser = new User(
            NULL,
            $requestResource->getName(),
            $requestResource->getEmail(),
            $requestResource->getpassword(),
            $requestResource->getRole(),
        );
       $newUserEloquent = $this->userMapper->fromEntityToEloquent($newUser,true);

       $correctInsert = $newUserEloquent->save();

       if(!$correctInsert) {
           throw new ErrorInRegisterNewUserException(
               "An error has occurred in registration",
               400
           );
       }

       return [
           'status' => 100,
           'message' => 'Correct new User insertion !',
           'access_token' => $newUserEloquent->createToken('auth_token')->plainTextToken,
           'token_type' => 'Bearer'
       ];
    }
}
