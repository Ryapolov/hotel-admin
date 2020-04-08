<?php


namespace App\Tests\Unit\Model\User\Application\Services;


use App\Modules\User\Application\Services\PasswordHasherService;
use PHPUnit\Framework\TestCase;

class PasswordHasherServiceTest extends TestCase
{
    /** @var PasswordHasherService */
    private $passwordHasher;

    public function setUp()
    {
        $this->passwordHasher = new PasswordHasherService();
    }

    public function testHash()
    {
        $this->assertIsString($this->passwordHasher->getHash('test_pass'));
    }

    public function testValidate()
    {
        $this->assertTrue($this->passwordHasher->validate('test_pass', $this->passwordHasher->getHash('test_pass')));
    }
}