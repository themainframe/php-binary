<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary;
use Binary\DataSet;
use Binary\Stream\StreamInterface;
use Binary\Field\Property\PropertyInterface;

/**
 * MaskedField
 * Represents a field that is composed of a number of bit subfields.
 *
 * @since 1.0
 */
class Mask extends AbstractField
{
    /**
     * The structure of the mask.
     *
     * @protected PropertyInterface
     */
    protected $structure = array();

    /**
     * @param PropertyInterface $structure
     * @return $this
     */
    public function setStructure(PropertyInterface $structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * @return PropertyInterface
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $result->push($this->name);

        // Read the bytes into memory
        $byte = $stream->readByte();
        $bitPosition = 0;

        // Get the structure
        $structure = $this->structure->get();

        foreach ($structure as $bitFieldName => $bitFieldSize) {

            $value = (ord($byte) >> $bitPosition) &
                bindec(str_repeat('1', $bitFieldSize));

            $result->setValue($bitFieldName, $value);

            $bitPosition += $bitFieldSize;
        }

        $result->pop();
    }

    /**
     * @todo Implement
     *
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        throw new \Exception('Not implemented');
    }
}
