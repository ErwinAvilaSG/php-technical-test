<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidNameException;

final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 3 || strlen($value) > 50) {
            throw new InvalidNameException("El nombre debe tener entre 3 y 50 caracteres.");
        }
        if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
            throw new InvalidNameException("El nombre solo puede contener letras y espacios.");
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
    public function __toString(): string
    {
        return $this->value;
    }
}
