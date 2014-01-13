<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Streams\StreamInterface;
use Binary\DataSet;

/**
 * TextField
 * Field.
 *
 * @since 1.0
 */
class Text extends AbstractField
{
    public function read(StreamInterface $stream, DataSet $result)
    {
        $bytes = $stream->read($this->size->get($result));
        $result->setValue($this->name, strval($bytes));
    }

    public function write(StreamInterface $stream, DataSet $result)
    {
        $bytes = $result->getValue($this->name);
        $stream->write($bytes);
    }
}
