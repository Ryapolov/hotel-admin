<?php


namespace App\Tests\Unit\Model\User\Application\Services;


use App\Modules\User\Application\Services\TokenizerService;
use PHPUnit\Framework\TestCase;

class TokenizerServiceTest extends TestCase
{
    public function testGenerate()
    {
        $tokenizer = new TokenizerService();

        $this->assertIsString($tokenizer->generate());
    }
}