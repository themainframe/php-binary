<?php
/**
 * ILDA (International Laser Display Association) Frame Handling in PHP.
 *
 * @package  php-ilda
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\Fields;
use Binary\Streams\StreamInterface;

/**
 * UnsignedInteger
 * Field.
 *
 * @since 1.0
 */
class UnsignedInteger implements FieldInterface
{
    public function read(StreamInterface $stream)
    {
        $data = $stream->read($this->size);

        if (strlen($data) < 2) {
            $data = str_pad($data, 2, "\0", STR_PAD_LEFT);
        }

        $unpacked = unpack('n', $data);

        return intval($unpacked[1]);
    }
}
