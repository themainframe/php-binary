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
 * Compound
 * A field that can comprise a number of fields and be repeated a number of times.
 *
 * @since 1.0
 */
class Compound extends AbstractField
{
    /**
     * @protected FieldInterface[] The fields enclosed within this compound field.
     */
    protected $fields = array();

    /**
     * @protected PropertyInterface The number of times this field will be repeated.
     */
    protected $count;

    /**
     * Assign properties as actual properties.
     */
    public function __construct()
    {
        $this->name = $this->getName();
        $this->count = new Property($this->count);
    }

    /**
     * @param PropertyInterface $count The number of times this compound field is repeated.
     *
     * @return $this
     */
    public function setCount(PropertyInterface $count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @param FieldInterface $field The field to add to the compound field.
     *
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        $result->push($this->getName());
        $count = isset($this->count) ? $this->count->get($result) : 1;

        // Read this compound field $count times
        for ($iteration = 0; $iteration < $count; $iteration ++) {
            $result->push($iteration);

            foreach ($this->fields as $field) {
                $field->read($stream, $result);
            }

            $result->pop();
        }

        $result->pop();
    }

    /**
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        $result->push($this->getName());
        $count = isset($this->count) ? $this->count->get($result) : 1;

        // Read this compound field $count times
        for ($iteration = 0; $iteration < $count; $iteration ++) {
            $result->push($iteration);

            foreach ($this->fields as $field) {
                $field->write($stream, $result);
            }

            $result->pop();
        }

        $result->pop();
    }
}
