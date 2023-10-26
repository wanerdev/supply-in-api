<?php

namespace App\SupplyIn\Domain\User\Mapper;

use App\SupplyIn\Domain\User\Eloquent\UserEloquent;
use App\SupplyIn\Domain\User\Entity\User;
use Illuminate\Support\Facades\Hash;

class UserMapper
{
    public function fromEntityToEloquent(User $user, bool $toCreate ):UserEloquent
    {
        $userEloquent = new UserEloquent();

        $userEloquent->name = $user->getName();
        $userEloquent->email = $user->getEmail();
        $userEloquent->role = $user->getRole();


        // Configura la contraseña según sea necesario
        if ($toCreate) {
            $userEloquent->password = Hash::make($user->getPassword());
        } else {

            $userEloquent->password = $user->getPassword();
        }


        return $userEloquent;
    }

    public function fromEloquentToEntity(UserEloquent $userEloquent) : User
    {
        return new User(
            $userEloquent->id,
            $userEloquent->name,
            $userEloquent->email,
            $userEloquent->password,
            $userEloquent->role
        );

    }
}
