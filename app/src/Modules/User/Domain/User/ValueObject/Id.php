<?php

namespace App\Modules\User\Domain\User\ValueObject;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    private $value;

    /**
     * Id constructor.
     *
     * @param $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    /**
     * @return Id
     * @throws \Exception
     */
    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * @param Id $id
     *
     * @return bool
     */
    public function equals(Id $id): bool
    {
        return $this->getValue() === $id->getValue();
    }
}