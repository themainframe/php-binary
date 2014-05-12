<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Stream;

use Serially\ConnectionInterface;

/**
 * SerialStream
 * A stream encapsulating a platform-agnostic serial port connection backed by themainframe/serially.
 *
 * The connection should be set up (I.e. baud rate & parity set) before being passed to the constructor.
 *
 * @since 1.0
 */
class SeriallyStream implements StreamInterface
{
    /**
     * @protected int The internal position of the stream.
     */
    protected $position = 0;

    /**
     * @protected ConnectionInterface The serial connection.
     */
    protected $connection = null;

    /**
     * @param ConnectionInterface $connection The handle to encapsulate.
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->handle = $connection;
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
        return $this->handle->readByte();
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
        return $this->handle->read($count);
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
        return $this->handle->writeByte($byte);
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
        return $this->handle->write($bytes);
    }

    /**
     * Instruct the stream handler to close and release any internal resources
     * or handles it encapsulates.
     *
     * @return boolean
     */
    public function close()
    {
        return $this->handle->close();
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
