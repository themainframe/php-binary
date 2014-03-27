<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Field\AbstractField;
use Binary\Field\FieldInterface;
use Binary\Field\Compound;
use Binary\Field\Property\Property;
use Binary\Field\Property\Backreference;
use Binary\Stream\StreamInterface;

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
    public $fields = array();

    /**
     * Initialise a new schema with a definition in the form of an array of fields.
     *
     * @param array $definition The field set to initialise the schema with.
     * @return $this
     */
    public function initWithArray(array $definition)
    {
        foreach ($definition as $fieldName => $field) {
            $this->addDefinedField($fieldName, $field);
        }

        return $this;
    }

    /**
     * @param FieldInterface $field
     * @param $definition
     */
    private function addPropertiesToField(FieldInterface $field, $definition)
    {
        // Set the properties on the field
        foreach ($definition as $propertyName => $propertyValue) {

            if (isset($propertyName[0]) && $propertyName[0] === '_') {
                // Don't add special-meaning _ fields
                continue;
            }

            if (isset($propertyValue[0]) && $propertyValue[0] === '@') {
                // Property is referencing an already-parsed field value
                $backreference = new Backreference();
                $backreference->setPath(substr($propertyValue, 1));
                $field->{$propertyName} = $backreference;
            } else {
                $field->{$propertyName} = new Property($propertyValue);
            }
        }
    }

    /**
     * @param FieldInterface $field
     * @param $definition
     */
    private function addValidatorsToField(FieldInterface $field, $definition)
    {
        // Set the validators on the field
        foreach ($definition as $validatorType => $validatorData) {
            $validatorClassName = __NAMESPACE__ . '\\Validator\\' . $validatorType;
            $validator = new $validatorClassName;
            $validator->setDesiredValue($validatorData);
            $field->addValidator($validator);
        }
    }

    /**
     * Add a new field to this schema instance, or to an existing CompoundField.
     *
     * @param string $fieldName The name of the field to add.
     * @param array $definition The definition (from JSON) of the field to add.
     * @param Compound $targetField The target compound field to add the new field to.
     */
    private function addDefinedField($fieldName, array $definition, Compound $targetField = null)
    {
        $className = __NAMESPACE__ . '\\Field\\' . $definition['_type'];

        $newField = new $className;

        // Assign the field name
        $newField->name = $fieldName;

        // Assign properties
        $this->addPropertiesToField($newField, $definition);

        // Assign validators
        if (isset($definition['_validators'])) {
            $this->addValidatorsToField($newField, $definition['_validators']);
        }

        // Are we adding a compound field?
        if (is_a($newField, __NAMESPACE__ . '\\Field\\Compound') &&
            isset($definition['_fields'])) {

            // Adding a compound field that has some subfields
            foreach ($definition['_fields'] as $subFieldName => $subFieldDefinition) {
                $this->addDefinedField($subFieldName, $subFieldDefinition, $newField);
            }
        }

        if ($targetField instanceof Compound) {
            // Adding the field to an existing compound field
            $targetField->addField($newField);
        } else {
            // Adding the field to this schema
            $this->addField($newField);
        }
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
}
