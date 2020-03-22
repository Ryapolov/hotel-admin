<?php


namespace App\Model\User\Application\Services;


use App\Model\User\Application\Services\Interfaces\ConfirmTokenSenderInterface;
use App\Model\User\Domain\User\ValueObject\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmTokenSenderService implements ConfirmTokenSenderInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * ConfirmTokenSender constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email, string $token, string $id): void
    {
        $message = (new TemplatedEmail())
            ->from($_ENV['MAILER_FROM_EMAIL'])
            ->to($email->getValue())
            ->subject('Confirm token')
            ->htmlTemplate('mail/user/confirm.token.html.twig')
            ->context([
                'id' => $id,
                'token' => $token,
            ]);

        $this->mailer->send($message);
    }
}