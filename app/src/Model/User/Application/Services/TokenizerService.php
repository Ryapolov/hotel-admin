<?php


namespace App\Model\User\Application\Services;



use Ramsey\Uuid\Uuid;

class TokenizerService
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}