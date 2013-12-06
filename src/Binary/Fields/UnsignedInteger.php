<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\DataSet;
use Binary\Streams\StreamInterface;


/**
 * UnsignedInteger
 * Field.
 *
 * @since 1.0
 */
class UnsignedInteger extends Field
{
    public function read(StreamInterface $stream, DataSet $result)
    {
        $data = $stream->read($this->size->get($result));

        if (strlen($data) < 2) {
            $data = str_pad($data, 2, "\0", STR_PAD_LEFT);
        }

        $unpacked = unpack('n', $data);
        $result->addValue($this->name, $unpacked[1]);
    }
}
