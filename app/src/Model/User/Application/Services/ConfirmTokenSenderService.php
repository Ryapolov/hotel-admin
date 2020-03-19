<?php


namespace App\Model\User\Application\Services;



use App\Model\User\Entity\User\Email;
use Symfony\Component\Mailer\Mailer;

class ConfirmTokenSenderService
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * ConfirmTokenSender constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email, string $token)
    {
        //$this->mailer->send();
    }
}