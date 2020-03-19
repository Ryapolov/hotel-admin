<?php


namespace App\Model\User\Application\Services;



class PasswordHasherService
{
    /**
     * @param string $password
     * @return string
     */
    public function getHash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2I);
        if ($hash === false) {
            throw new \RuntimeException('Unable to generate hash.');
        }

        return $hash;
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}