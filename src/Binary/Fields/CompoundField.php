<?php
/**
 * ILDA (International Laser Display Association) Frame Handling in PHP.
 *
 * @package  php-ilda
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields;

use Binary\Fields;
use Binary\Streams\StreamInterface;

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
     * @param string $fieldName The name of the field to add.
     * @param FieldInterface $field The field to add to the compound field.
     */
    public function addField($fieldName, FieldInterface $field)
    {
        $this->fields[$fieldName] = $field;
    }

    /**
     * @param StreamInterface $stream The stream to read fields from.
     * @return array
     */
    public function read(StreamInterface $stream)
    {
        $readFields = array();
        $count = isset($this->count) ? $this->count : 1;

        // Read this compound field $count times
        for ($iteration = 0; $iteration < $count; $iteration ++) {

            $subFields = array();

            foreach ($this->fields as $fieldName => $field) {
                $subFields[$fieldName] = $field->read($stream);
            }

            $readFields[] = $subFields;
        }

        return $readFields;
    }
}
