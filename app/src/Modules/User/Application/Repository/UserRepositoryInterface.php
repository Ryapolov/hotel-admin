<?php

namespace App\Modules\User\Application\Repository;

use App\Modules\User\Domain\User\User;

interface UserRepositoryInterface
{
    public function add(): void;

    public function get(): User;
}