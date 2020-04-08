<?php

namespace App\Security;

use App\Modules\User\Application\Query\FindUserByEmailQuery;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var FindUserByEmailQuery
     */
    private $findUserByEmailQuery;

    public function __construct(FindUserByEmailQuery $findUserByEmailQuery)
    {
        $this->findUserByEmailQuery = $findUserByEmailQuery;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->findUserByEmailQuery->execute($username, ['id', 'email', 'password', 'status', 'role']);
        if (!$user) {
            throw new UsernameNotFoundException('');
        }

        return new UserIdentity($user->id, $user->email, $user->password, $user->role, $user->status);
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class): bool
    {
        return $class === UserIdentity::class;
    }
}