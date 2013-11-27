<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\Streams\StreamInterface;
use Binary\Result;

/**
 * CompoundField
 * A field that can comprise a number of fields.
 *
 * @since 1.0
 */
class CompoundField implements FieldInterface
{
    /**
     * @protected array The fields enclosed within this compound field.
     */
    protected $fields = array();

    /**
     * @param int $count The number of times this compound field is repeated.
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @param FieldInterface $field The field to add to the compound field.
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @param StreamInterface $stream The stream to read fields from.
     * @param Result $result The result to add the value to.
     * @return array
     */
    public function read(StreamInterface $stream, Result $result)
    {
        $result->push($this->name);
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
}
