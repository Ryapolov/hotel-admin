<?php


namespace App\Model\User\Repository;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {

    }

    public function hasByEmail(Email $email): bool
    {
        return true;
    }

    public function get(Id $id): bool
    {
        return true;
    }

    public function getByToken(string $token):bool
    {
        return true;

    }
}