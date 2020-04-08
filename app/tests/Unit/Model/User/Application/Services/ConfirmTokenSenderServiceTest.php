<?php


namespace App\Tests\Unit\Model\User\Application\Services;


use App\Modules\User\Application\Services\ConfirmTokenSenderService;
use App\Modules\User\Domain\User\ValueObject\Email;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmTokenSenderServiceTest extends TestCase
{
    public function testSend()
    {
        $mailer = $this->createMock(MailerInterface::class);
        $tokenSender = new ConfirmTokenSenderService($mailer);

        $this->assertNull($tokenSender->send(new Email('test@mail.ru'), 'test_token', 'test_id'));
    }
}