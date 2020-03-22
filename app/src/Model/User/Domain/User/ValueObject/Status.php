<?php

namespace App\Model\User\Domain\User\ValueObject;

use Webmozart\Assert\Assert;

class Status
{
    public const ACTIVE = 'ACTIVE';
    public const NEW = 'NEW';
    public const BLOCKED = 'BLOCKED';

    private $value;

    /**
     * Status constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, [self::ACTIVE, self::NEW, self::BLOCKED]);

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @return Status
     */
    public static function activate(): Status
    {
        return new self(self::ACTIVE);
    }

    /**
     * @return Status
     */
    public static function new(): Status
    {
        return new self(self::NEW);
    }

    /**
     * @return Status
     */
    public static function blocked(): Status
    {
        return new self(self::BLOCKED);
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->value === self::BLOCKED;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->value === self::NEW;
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}