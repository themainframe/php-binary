<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Stream\StreamInterface;
use Binary\DataSet;

/**
 * Padding field represents empty (insignificant) stream area, that need to be skipped
 *
 * @since 1.0
 */
class Padding extends AbstractSizedField
{
    /**
     * Skip ahead $this->size bytes in the stream.
     * Do not mutate the result DataSet at all.
     *
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $stream->read($this->size->get($result));
    }

    /**
     * Write $this->size NUL bytes to $stream.
     *
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $stream->write(pack('x' . $this->size->get($result)));
    }
}
