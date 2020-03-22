<?php

namespace App\Model\User\Domain\User\ValueObject;

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

    /**
     * @return Role
     */
    public static function userWaitConfirm(): Role
    {
        return new self(self::USER_WAIT_CONFIRM);
    }

    /**
     * @return bool
     */
    public function isUserWaitConfirm(): bool
    {
        return$this->value === self::USER_WAIT_CONFIRM;
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