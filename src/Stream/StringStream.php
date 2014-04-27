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
 * StringStream
 * A stream encapsulating a string.
 *
 * @since 1.0
 */
class StringStream implements StreamInterface
{
    /**
     * @protected int The internal position of the stream.
     */
    protected $position = 0;

    /**
     * @protected string The inner string encapsulated by the Stream.
     */
    protected $string = '';

    /**
     * @param string $string The string to encapsulate.
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
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

        return strlen($this->string) > $this->position - 1 ?
            $this->string[$this->position - 1] : false;
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
        return substr($this->string, $this->position - $count, $count);
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
        $this->position ++;
        $this->string .= $byte;

        return $this->position;
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
        $this->position += strlen($bytes);
        $this->string .= $bytes;

        return $bytes;
    }

    /**
     * Instruct the stream handler to close and release any internal resources
     * or handles it encapsulates.
     *
     * @return boolean
     */
    public function close()
    {
        // No resources need to be released for a string-based stream
        return true;
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
