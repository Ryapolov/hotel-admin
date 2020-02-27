<?php


namespace App\Model\User\Repository;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;

class UserRepository
{
    public function add(User $user): void
    {

    }

    public function hasByEmail(Email $email): bool
    {
        return true;
    }

    public function get(Id $id): User
    {

    }

    public function getByToken(string $token):User
    {

    }
}