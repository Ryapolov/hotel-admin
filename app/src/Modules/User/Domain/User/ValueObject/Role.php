<?php

namespace App\Modules\User\Domain\User\ValueObject;

use Webmozart\Assert\Assert;

class Role
{
    public const ADMIN = 'ROLE_ADMIN';
    public const USER = 'ROLE_USER';
    public const USER_WAIT_CONFIRM = 'ROLE_USER_WAIT_CONFIRM';


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