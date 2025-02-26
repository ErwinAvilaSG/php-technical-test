<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\WeakPasswordException;

final class Password
{
    private string $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function create(string $plainPassword): self
    {
        self::ensureIsValidPassword($plainPassword);
        return new self(password_hash($plainPassword, PASSWORD_DEFAULT));
    }

    private static function ensureIsValidPassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new WeakPasswordException("La contraseña debe tener al menos 8 caracteres.");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new WeakPasswordException("La contraseña debe contener al menos una letra mayúscula.");
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new WeakPasswordException("La contraseña debe contener al menos un número.");
        }
        if (!preg_match('/[\W]/', $password)) {
            throw new WeakPasswordException("La contraseña debe contener al menos un carácter especial.");
        }
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function value(): string
    {
        return $this->hash;
    }

    public function __toString(): string
    {
        return $this->hash;
    }
    public static function fromHash(string $hash): self
{
    // Se crea la instancia sin validar (ya que el hash ya es seguro)
    return new self($hash);
}
}
