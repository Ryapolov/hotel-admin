<?php


namespace App\Security;


use App\Modules\User\Domain\User\ValueObject\Status;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, EquatableInterface
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $role;
    /**
     * @var string
     */
    private $status;

    public function __construct(string $id, string $username, string $password, string $role, string $status)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }

    public function isActive(): bool
    {
        return $this->status === Status::ACTIVE;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function isEqualTo(UserInterface $user)
    {
        return
            $this->id === $user->id &&
            $this->password === $user->password &&
            $this->role === $user->role &&
            $this->status === $user->status;
    }
}