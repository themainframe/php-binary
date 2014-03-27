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
 * StreamInterface
 * The interface for a sequence of bytes with no fixed end-point.
 *
 * @since 1.0
 */
interface StreamInterface
{
    /**
     * Reads a single byte from the stream and advances the internal position by 1.
     * Returns false if reading is not possible (EOF, error).
     *
     * @return false|string
     */
    public function readByte();

    /**
     * Reads a number of bytes equal to $count from the stream and advances the internal
     * position by the appropriate amount.
     *
     * @param int $count The number of bytes to read.
     * @return string
     */
    public function read($count);

    /**
     * Writes a single byte to the stream and advances the internal position by 1.
     * Returns the new position as an integer on success, or false on failure.
     *
     * @param string $byte The byte to write to the stream.
     * @return false|int
     */
    public function writeByte($byte);

    /**
     * Writes a number of bytes to the stream and advances the internal
     * position by the appropriate amount.
     *
     * @param string $bytes The bytes to write to the stream.
     * @return string
     */
    public function write($bytes);

    /**
     * Instruct the stream handler to close and release any internal resources
     * or handles it encapsulates.
     *
     * @return boolean
     */
    public function close();

    /**
     * Gets the current position of the internal stream cursor.
     *
     * @return int
     */
    public function getPosition();
}
