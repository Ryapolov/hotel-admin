<?php

namespace App\Modules\User\Domain\User\ValueObject;

class Email
{
    /** @var string  */
    private $value;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Incorrect email.');
        }
        $this->value = mb_strtolower($value);
    }

    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function equals(Email $email): bool
    {
        return $this->getValue() === $email->getValue();
    }
}