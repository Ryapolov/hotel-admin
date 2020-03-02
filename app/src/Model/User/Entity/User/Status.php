<?php


namespace App\Model\User\Entity\User;


use Webmozart\Assert\Assert;

class Status
{
    public const ACTIVE = 'ACTIVE';
    public const NEW = 'NEW';

    private $value;

    /**
     * Status constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, [self::ACTIVE, self::NEW]);

        $this->value = $value;
    }

    /**
     * @return Status
     */
    public static function activation(): Status
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