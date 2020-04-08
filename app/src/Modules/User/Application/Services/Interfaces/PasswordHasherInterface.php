<?php


namespace App\Modules\User\Application\Services\Interfaces;


interface PasswordHasherInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function getHash(string $password): string;

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validate(string $password, string $hash): bool;
}