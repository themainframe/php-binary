<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Stream;

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
     * @param resource $handle The handle to encapsulate.
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
     * Writes a single byte to the stream and advances the internal position by 1.
     * Returns the new position as an integer on success, or false on failure.
     *
     * @param string $byte The byte to write to the stream.
     * @return false|int
     */
    public function writeByte($byte)
    {
        return fwrite($this->handle, $byte, 1);
    }

    /**
     * Writes a number of bytes to the stream and advances the internal
     * position by the appropriate amount.
     *
     * @param string $bytes The bytes to write to the stream.
     * @return string
     */
    public function write($bytes)
    {
        return fwrite($this->handle, $bytes, strlen($bytes));
    }

    /**
     * Instruct the stream handler to close and release any internal resources
     * or handles it encapsulates.
     *
     * @return boolean
     */
    public function close()
    {
        return fclose($this->handle);
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
