<?php
/**
 * ILDA (International Laser Display Association) Frame Handling in PHP.
 *
 * @package  php-ilda
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Streams;

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
     * @param $string The string to encapsulate.
     */
    public function __construct($string)
    {
        $this->string = $string;
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
     * Gets the current position of the internal stream cursor.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
