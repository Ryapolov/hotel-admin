<?php

namespace App\Tests\Unit\Model\User\Application\Command\Activate;

use App\Model\User\Application\Command\Activate\ActivateCommand;
use App\Model\User\Application\Command\Activate\ActivateHandler;
use App\Model\User\Application\Repository\UserRepositoryInterface;
use App\Tests\Builder\UserBuilder;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ActivateHandlerTest extends TestCase
{
    public function testHandle()
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class)
            ->method('get')
            ->willReturn(UserBuilder::create());

        $em = $this->createMock(EntityManagerInterface::class);

        $activateHandler = new ActivateHandler($userRepository, $em);

        $command = new ActivateCommand();
        $command->id = '1';

        $this->assertNull($activateHandler->handle($command));
    }

    // public function testHandleException()
    // {
    //     $activateHandler = new ActivateHandler();
    //
    //     $activateHandler->handle();
    // }
}