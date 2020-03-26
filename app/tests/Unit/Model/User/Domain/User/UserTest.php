<?php


namespace App\Tests\Unit\Model\User\Domain\User;

use App\Model\User\Domain\User\User;
use App\Model\User\Domain\User\ValueObject\Email;
use App\Model\User\Domain\User\ValueObject\Id;
use App\Model\User\Domain\User\ValueObject\Name;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = User::create(
            new Id($id = '1'),
            new Email($email = 'test@email.ru'),
            new Name($first = 'james', $last = 'bond'),
            new \DateTimeImmutable(),
            $token = 'token'
        );

        $this->assertEquals($id, $user->getId()->getValue());
        $this->assertEquals($email, $user->getEmail()->getValue());
        $this->assertEquals($first, $user->getName()->getFirst());
        $this->assertEquals($last, $user->getName()->getLast());
        $this->assertEquals($token, $user->getConfirmToken());
        $this->assertTrue($user->getStatus()->isNew());
        $this->assertTrue($user->getRole()->isUser());
    }
}