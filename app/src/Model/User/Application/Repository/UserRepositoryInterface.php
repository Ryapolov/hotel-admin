<?php

namespace App\Model\User\Application\Repository;

use App\Model\User\Domain\User\User;

interface UserRepositoryInterface
{
    public function add(): void;

    public function get(): User;
}