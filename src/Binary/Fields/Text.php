<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\Streams\StreamInterface;

/**
 * TextField
 * Field.
 *
 * @since 1.0
 */
class Text extends Field
{
    public function read(StreamInterface $stream, \Binary\DataSet $result)
    {
        $bytes = $stream->read($this->size->get($result));
        $result->addValue($this->name, strval($bytes));
    }
}
