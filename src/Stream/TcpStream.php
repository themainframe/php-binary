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
 * TcpStream
 * A stream encapsulating a TCP socket.
 *
 * @since 1.0
 */
class TcpStream implements StreamInterface
{
    /**
     * @protected Resource
     */
    protected $socket;

    /**
     * @param string $host The hostname or IP to open the socket with
     * @param int $port The port to connect to
     * @param int $timeout The maximum time to await a connection
     */
    public function __construct($host, $port, $timeout = 5)
    {
        $errno = $errstr = '';
        $this->socket = fsockopen($host, $port, $errno, $errstr, $timeout);
    }

    /**
     * Reads a single byte from the stream and advances the internal position by 1.
     * Returns false if reading is not possible (EOF, error).
     *
     * @return false|string
     */
    public function readByte()
    {;
        return fread($this->socket, 1);
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
        return fread($this->socket, $count);
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
        return fwrite($this->socket, $byte, 1);
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
        return fwrite($this->socket, $bytes, strlen($bytes));
    }

    /**
     * Instruct the stream handler to close and release any internal resources
     * or handles it encapsulates.
     *
     * @return boolean
     */
    public function close()
    {
        return fclose($this->socket);
    }

    /**
     * Gets the current position of the internal stream cursor.
     * Network sockets do not have a determinable position.
     *
     * @return int
     */
    public function getPosition()
    {
        return -1;
    }
}
