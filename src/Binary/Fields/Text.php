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
class Text implements FieldInterface
{
    public function read(StreamInterface $stream)
    {
        $bytes = $stream->read($this->size);
        return strval($bytes);
    }
}
