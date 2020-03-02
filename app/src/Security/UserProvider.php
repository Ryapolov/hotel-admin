<?php


namespace App\Security;


use App\ReadModel\User\UserFether;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserFether
     */
    private $userFetcher;

    public function __construct(UserFether $userFetcher)
    {
        $this->userFetcher = $userFetcher;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->userFetcher->findForAuthByEmail($username);
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
        return $class instanceof UserIdentity;
    }
}