<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Field\Property\Property;
use Binary\Field\Property\PropertyInterface;
use Binary\Stream\StreamInterface;
use Binary\DataSet;

/**
 * Delimited
 * Field.
 *
 * Represents a field that has a known sequence of bytes marking the end of it.
 *
 * The sequence of bytes used as the delimiter may be a Backreference to a previously-parsed
 * field value.
 *
 * @since 1.0
 */
class Delimited extends AbstractField
{
    /**
     * The sequence of bytes that marks the end of the field.
     *
     * @public \Binary\Field\Property\PropertyInterface
     */
    protected $delimiter = "\n";

    /**
     * The maximum number of bytes to search ahead looking for $delimiter.
     *
     * @public \Binary\Field\Property\PropertyInterface
     */
    protected $searchLength = 128;

    /**
     * Set up the field
     */
    public function __construct()
    {
        $this->delimiter = new Property($this->delimiter);
        $this->searchLength = new Property($this->searchLength);
    }

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        // Get the delimiter to search for
        $delimiter = $this->delimiter->get($result);
        $delimiterLength = strlen($delimiter);
        $value = '';

        while (false !== ($byte = $stream->readByte())) {
            $value .= $byte;

            // Does the string now end with the requested delimiter?
            if (substr($value, strlen($value) - $delimiterLength, $delimiterLength) === $delimiter) {
                break;
            }

            // Reached the limit of the lookahead?
            if (strlen($value) > $this->searchLength->get($result)) {
                break;
            }
        }

        // Strip the delimiter and add the read content to the result DataSet
        $value = substr($value, 0, strlen($value) - $delimiterLength);

        // Validate and return
        $this->validate($value);
        $result->setValue($this->name, $value);
    }

    /**
     * Write the value for this field, then the delimiter at the end.
     *
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $stream->write($result->getValue($this->getName()));
        $stream->write($this->delimiter->get($result));
    }

    /**
     * @param PropertyInterface $searchLength
     *
     * @return $this
     */
    public function setSearchLength(PropertyInterface $searchLength)
    {
        $this->searchLength = $searchLength;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSearchLength()
    {
        return $this->searchLength;
    }

    /**
     * @param PropertyInterface $delimiter
     *
     * @return $this
     */
    public function setDelimiter(PropertyInterface $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }
}
