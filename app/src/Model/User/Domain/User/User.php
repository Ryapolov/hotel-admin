<?php

namespace App\Model\User\Domain\User;


use App\Model\User\Domain\User\ValueObject\Email;
use App\Model\User\Domain\User\ValueObject\Id;
use App\Model\User\Domain\User\ValueObject\Name;
use App\Model\User\Domain\User\ValueObject\Role;
use App\Model\User\Domain\User\ValueObject\Status;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\User\Application\Repository\UserRepository")
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

    public function __construct(Id $id, Email $email, Name $name, \DateTimeImmutable $createDate, string $confirmToken)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->createDate = $createDate;
        $this->status = Status::new();
        $this->role = Role::user();
        $this->confirmToken = $confirmToken;
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
    public function getConfirmToken(): string
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
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }
}