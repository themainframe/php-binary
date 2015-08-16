<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Exception\SchemaException;
use Binary\Field\FieldInterface;
use Binary\Stream\StreamInterface;
use Binary\Validator\ValidatorInterface;

/**
 * Schema
 *
 * Represents the internal structure of a binary field file & performs the mapping
 * between the schema definition and the object graph of fields and validators.
 *
 * @since 1.0
 */
class Schema
{
    /**
     * @var array The fields contained by this schema.
     */
    private $fields = array();

    /**
     * Utility method to spawn a Field of a specific type.
     *
     * @param $type
     * @return FieldInterface
     * @throws Exception\SchemaException
     */
    public static function createField($type)
    {
        // Create the field
        $className = __NAMESPACE__ . '\\Field\\' . $type;

        if (!class_exists($className)) {
            throw new SchemaException(
                sprintf('The requested field class "%s" cannot be found.', $type)
            );
        }

        $newField = new $className;

        if (!($newField instanceof FieldInterface)) {
            throw new SchemaException(
                sprintf('The requested field class "%s" does not implement FieldInterface.', $type)
            );
        }

        return $newField;
    }

    /**
     * Utility method to spawn a Validator of a specific type.
     *
     * @param $type
     * @return ValidatorInterface
     * @throws Exception\SchemaException
     */
    public static function createValidator($type)
    {
        // Create the validator
        $className = __NAMESPACE__ . '\\Validator\\' . $type;

        if (!class_exists($className)) {
            throw new SchemaException(
                sprintf('The requested validator class "%s" cannot be found.', $type)
            );
        }

        $newValidator = new $className;

        if (!($newValidator instanceof ValidatorInterface)) {
            throw new SchemaException(
                sprintf('The requested validator class "%s" does not implement ValidatorInterface.', $type)
            );
        }

        return $newValidator;
    }

    /**
     * @param Field\FieldInterface $field The field to add to the schema.
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * @param StreamInterface $stream The stream to parse.
     * @param DataSet $set Optionally an existing data set to extend.
     * @return array
     */
    public function readStream(StreamInterface $stream, DataSet $set = null)
    {
        $result = $set instanceof DataSet ? $set : new DataSet();

        foreach ($this->fields as $field) {
            $field->read($stream, $result);
        }

        return $result->getData();
    }

    /**
     * @param StreamInterface $stream
     * @param DataSet $data
     */
    public function writeStream(StreamInterface $stream, DataSet $data)
    {
        foreach ($this->fields as $field) {
            $field->write($stream, $data);
        }
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }
}
