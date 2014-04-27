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
 * TextField
 * Field.
 *
 * @since 1.0
 */
class Text extends AbstractField
{
    /**
     * The size of this field within the stream.
     *
     * @public \Binary\Field\Property\PropertyInterface
     */
    public $size;

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $bytes = $stream->read($this->size->get($result));
        $this->validate(strval($bytes));
        $result->setValue($this->name, strval($bytes));
    }

    /**
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $bytes = substr($result->getValue($this->name), 0, $this->size->get($result));
        $stream->write($bytes);
    }
}
