<?php
/**
 * ILDA (International Laser Display Association) Frame Handling in PHP.
 *
 * @package  php-ilda
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Streams;

/**
 * FileStream
 * A stream encapsulating a file handle.
 *
 * @since 1.0
 */
class FileStream implements StreamInterface
{
    /**
     * @protected int The internal position of the stream.
     */
    protected $position = 0;

    /**
     * @protected resource The file handle.
     */
    protected $handle = null;

    /**
     * @param $handle The handle to encapsulate.
     */
    public function __construct($handle)
    {
        $this->handle = $handle;
    }

    /**
     * Reads a single byte from the stream and advances the internal position by 1.
     * Returns false if reading is not possible (EOF, error).
     *
     * @return false|string
     */
    public function readByte()
    {
        $this->position ++;
        return fread($this->handle, 1);
    }

    /**
     * Reads a number of bytes equal to $count from the stream and advances the internal
     * position by the appropriate amount.
     *
     * @param int $count The number of bytes to read.
     * @return string
     */
    public function read($count)
    {
        $this->position += $count;
        return fread($this->handle, $count);
    }

    /**
     * Gets the current position of the internal stream cursor.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
