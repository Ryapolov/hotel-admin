<?php


namespace App\Model\User\Application\Services\Interfaces;


use App\Model\User\Domain\User\ValueObject\Email;

interface ConfirmTokenSenderInterface
{
    /**
     * @param Email $email
     * @param string $token
     * @param string $id
     * @return mixed
     */
    public function send(Email $email, string $token, string $id): void ;
}