<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Field\Property\PropertyInterface;
use Binary\Stream\StreamInterface;
use Binary\DataSet;

/**
 * Conditional
 * Field.
 *
 * Represents a virtual field that may or may not be present, depending on the result of a callback result.
 * The callback will be provided in the condition property of the field, and will be called for each occurrence of the
 * field within the schema.
 *
 * The callback will be passed the current DataSet instance as an argument. If the callback returns a true value, the
 * field will be read or written, otherwise the field will not be read or written and parsing will resume from the
 * current location within the stream.
 */
class Conditional extends Compound
{
    /**
     * @var PropertyInterface
     */
    protected $condition;

    /**
     * @param PropertyInterface $condition
     */
    public function setCondition(PropertyInterface $condition)
    {
        $this->condition = $condition;
    }

    /**
     * {@inheritdoc}
     */
    public function read(StreamInterface $stream, DataSet $result)
    {
        // If there's no condition set, simply assume this field won't be here.
        if (!$this->condition) {
            return;
        }

        // Decide if we should read a field here
        $condition = $this->condition->get($result);

        if (is_callable($condition)) {
            if ($condition($result)) {

                $value = parent::read($stream, $result);

                // Validate and save
                $this->validate($value);
                $result->setValue($this->name, $value);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write(StreamInterface $stream, DataSet $result)
    {
        // If there's no condition set, simply assume this field won't be written.
        if (!$this->condition) {
            return;
        }

        // Decide if we should read a field here
        $condition = $this->condition->get($result);

        if (is_callable($condition)) {
            if ($condition($result)) {
                parent::write($stream, $result);
            }
        }
    }

}
