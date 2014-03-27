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
 * UnsignedInteger
 * Field.
 *
 * @since 1.0
 */
class UnsignedInteger extends AbstractField
{
    public function read(StreamInterface $stream, DataSet $result)
    {
        $data = $stream->read($this->size->get($result));

        if (strlen($data) < 2) {
            $data = str_pad($data, 2, "\0", STR_PAD_LEFT);
        }

        $unpacked = unpack('n', $data);
        $this->validate($unpacked[1]);
        $result->setValue($this->name, $unpacked[1]);
    }

    /**
     * Read from a DataSet and write the translated data in to a
     * StreamInterface-implementing object.
     *
     * @param StreamInterface $stream
     * @param DataSet $result
     * @return mixed
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $bytes = $result->getValue($this->name);
        $stream->write(pack('c', intval($bytes)));
    }
}
