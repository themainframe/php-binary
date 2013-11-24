<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary;
use Binary\Streams\StreamInterface;

/**
 * MaskedField
 * Represents a field that is composed of a number of bit subfields.
 *
 * @since 1.0
 */
class MaskedField extends Field
{
    public function read(StreamInterface $stream, Result $result)
    {
        $result->push($this->name);

        // Read the bytes into memory
        $byte = $stream->readByte();
        $bitPosition = 0;

        foreach ($this->structure as $bitFieldName => $bitFieldSize) {

            $value = (ord($byte) >> $bitPosition) &
                bindec(str_repeat('1', $bitFieldSize));

            $result->addValue($bitFieldName, $value);

            $bitPosition += $bitFieldSize;
        }

        $result->pop();
    }
}
