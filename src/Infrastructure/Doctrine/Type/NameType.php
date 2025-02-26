<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class NameType extends Type
{
    public const NAME = 'name';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        // Se almacena como VARCHAR
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Name
    {
        if ($value === null || $value instanceof Name) {
            return $value;
        }
        return new Name($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        if (!$value instanceof Name) {
            throw new \InvalidArgumentException('Se esperaba un objeto de tipo Name.');
        }
        return $value->value();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
