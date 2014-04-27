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
 * FieldInterface
 * Specifies the interface for deriving values from fields.
 *
 * @since 1.0
 */
interface FieldInterface
{
    /**
     * Read from StreamInterface-implementing object and insert the
     * derived data into a DataSet.
     *
     * @param \Binary\Stream\StreamInterface $stream
     * @param DataSet $result
     * @return mixed
     */
    public function read(StreamInterface $stream, DataSet $result);

    /**
     * Read from a DataSet and write the translated data in to a
     * StreamInterface-implementing object.
     *
     * @param StreamInterface $stream
     * @param DataSet $result
     * @return mixed
     */
    public function write(StreamInterface $stream, DataSet $result);
}
