<?php

namespace App\Modules\User\Domain\User;


use App\Modules\User\Domain\User\ValueObject\Email;
use App\Modules\User\Domain\User\ValueObject\Id;
use App\Modules\User\Domain\User\ValueObject\Name;
use App\Modules\User\Domain\User\ValueObject\Role;
use App\Modules\User\Domain\User\ValueObject\Status;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"}),
 *     @ORM\UniqueConstraint(columns={"confirm_token"})
 * })
 */
class User
{
    /**
     * @var Id
     * @ORM\Id
     * @ORM\Column(type="user_user_id")
     */
    private $id;
    /**
     * @var Email
     * @ORM\Column(type="user_user_email")
     */
    private $email;
    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\User\Domain\User\ValueObject\Name")
     */
    private $name;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable")
     */
    private $createDate;
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;
    /**
     * @var string|null
     * @ORM\Column(type="string", name="confirm_token", nullable=true)
     */
    private $confirmToken;
    /**
     * @var Status
     * @ORM\Column(type="user_user_status")
     */
    private $status;
    /**
     * @var Role
     * @ORM\Column(type="user_user_role")
     */
    private $role;

    private function __construct(Id $id, Email $email, \DateTimeImmutable $createDate)
    {
        $this->id = $id;
        $this->email = $email;
        $this->createDate = $createDate;
    }

    /**
     * @param Id $id
     * @param Email $email
     * @param Name $name
     * @param \DateTimeImmutable $createDate
     * @param string $confirmToken
     * @return User
     */
    public static function create(Id $id, Email $email, Name $name, \DateTimeImmutable $createDate, string $confirmToken): User
    {
        $user = new self($id, $email, $createDate);
        $user->name = $name;
        $user->confirmToken = $confirmToken;
        $user->status = Status::new();
        $user->role = Role::user();

        return $user;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    /**
     * @param Status $status
     *
     * @return User
     */
    public function setStatus(Status $status): User
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function confirmByToken(): void
    {
        $this->setStatus(Status::activate());
        $this->setRole(Role::user());
        $this->confirmToken = null;
    }

    /**
     * @param Email $email
     * @return User
     */
    public function setEmail(Email $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Name $name
     * @return User
     */
    public function setName(Name $name): User
    {
        $this->name = $name;

        return $this;
    }
}