<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PasswordType extends Type
{
    public const NAME = 'password';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        // Se almacena como VARCHAR
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Password
    {
        if ($value === null || $value instanceof Password) {
            return $value;
        }
        return Password::fromHash($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        if (!$value instanceof Password) {
            throw new \InvalidArgumentException('Se esperaba un objeto de tipo Password.');
        }
        return $value->hash();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
