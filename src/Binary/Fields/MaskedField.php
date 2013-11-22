<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\Fields;
use Binary\Streams\StreamInterface;

/**
 * MaskedField
 * Represents a field that is composed of a number of bit subfields.
 *
 * @since 1.0
 */
class MaskedField implements FieldInterface
{
    public function read(StreamInterface $stream)
    {
        // Read the bytes into memory
        $byte = $stream->readByte();
        $bitFields = array();
        $bitPosition = 0;

        foreach ($this->structure as $bitFieldName => $bitFieldSize) {

            $bitFields[$bitFieldName] = (ord($byte) >> $bitPosition) &
                bindec(str_repeat('1', $bitFieldSize));

            $bitPosition += $bitFieldSize;
        }

        return $bitFields;
    }
}
