<?php
/**
 * ILDA (International Laser Display Association) Frame Handling in PHP.
 *
 * @package  php-ilda
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Streams;

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
     * Gets the current position of the internal stream cursor.
     *
     * @return int
     */
    public function getPosition();
}
