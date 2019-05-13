<?php
declare(strict_types=1);

namespace Pfazzi\Isbn\Doctrine;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Pfazzi\Isbn\Isbn;

/**
 * Field type mapping for the Doctrine Database Abstraction Layer (DBAL).
 *
 * Isbn fields will be stored as a string in the database and converted back to
 * the Isbn value object when querying.
 */
class IsbnType extends Type
{
    const NAME = 'isbn';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $field['length'] = 36;
        $field['fixed']  = true;

        return $platform->getVarcharTypeDeclarationSQL($field);
    }

    public function getName()
    {
        return static::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Isbn) {
            return $value->toString();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Isbn) {
            return $value;
        }

        try {
            $isbn = Isbn::fromString($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $isbn;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}