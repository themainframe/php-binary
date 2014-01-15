<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary;
use Binary\DataSet;
use Binary\Stream\StreamInterface;

/**
 * MaskedField
 * Represents a field that is composed of a number of bit subfields.
 *
 * @since 1.0
 */
class Mask extends AbstractField
{
    public function read(StreamInterface $stream, DataSet $result)
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

    /**
     * @todo Implement
     * @param StreamInterface $stream
     * @param DataSet $result
     * @return mixed|void
     * @throws \Exception
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        throw new \Exception('Not implemented');
    }
}
