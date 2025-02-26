<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

final class UserId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function generate(): self
    {
        return new self(uniqid());
    }
    public function __toString(): string
    {
        return $this->value;
    }
}
