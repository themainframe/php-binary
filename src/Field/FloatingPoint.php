<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\DataSet;
use Binary\Stream\StreamInterface;

/**
 * FloatingPoint.
 * Field.
 *
 * @since 1.0
 */
class FloatingPoint extends AbstractSizedField
{
    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $data = $stream->read($this->size->get($result));

        if (strlen($data) < 2) {
            $data = str_pad($data, 2, "\0", STR_PAD_LEFT);
        }

        $unpacked = unpack('f', $data);
        $this->validate($unpacked[1]);
        $result->setValue($this->name, $unpacked[1]);
    }

    /**
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        //Writing floats currently untested
        $bytes = $result->getValue($this->name);
        $stream->write(pack('f', intval($bytes)));
    }
}
