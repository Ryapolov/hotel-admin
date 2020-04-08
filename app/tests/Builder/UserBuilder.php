<?php

namespace App\Tests\Builder;

use App\Modules\User\Domain\User\User;
use App\Modules\User\Domain\User\ValueObject\Email;
use App\Modules\User\Domain\User\ValueObject\Id;
use App\Modules\User\Domain\User\ValueObject\Name;
use App\Modules\User\Domain\User\ValueObject\Status;

class UserBuilder
{
    /**
     * @return User
     * @throws \Exception
     */
    public static function create(): User
    {
        return User::create(
            new Id('1'),
            new Email('test@mail.ru'),
            new Name('James', 'Bond'),
            new \DateTimeImmutable(),
            'token'
        );
    }

    /**
     * @return User
     * @throws \Exception
     */
    public static function createActiveUser(): User
    {
         $user = self::create();
         $user->setStatus(Status::activate());

         return $user;
    }
}