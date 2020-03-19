<?php

namespace App\Model\User\Domain\User\ValueObject;

use Webmozart\Assert\Assert;

class Role
{
    const ADMIN = 'ROLE_ADMIN';
    const USER = 'ROLE_USER';

    private $value;

    public function __construct(string $value)
    {
        Assert::oneOf($value, [self::ADMIN, self::USER]);
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @return Role
     */
    public static function admin(): Role
    {
        return new self(self::ADMIN);
    }

    /**
     * @return Role
     */
    public static function user(): Role
    {
        return new self(self::USER);
    }

    public function isUser()
    {
        return $this->value === self::USER;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}