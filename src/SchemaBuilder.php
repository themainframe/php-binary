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
use Binary\Field\Compound;
use Binary\Field\Property\Property;
use Binary\Field\Property\Backreference;
use Binary\Field\Property\PropertyInterface;
use Binary\Stream\StreamInterface;

/**
 * SchemaBuilder
 *
 * Factory for producing Schemas from array-style definitions.
 * Typically the schema array will be derived from a JSON or XML serialisation.
 *
 * @since 1.0
 */
class SchemaBuilder
{
    /**
     * Initialise a new schema with a definition in the form of an array of fields.
     *
     * @param array $definition The field set to initialise the schema with.
     * @return Schema
     */
    public function createFromArray(array $definition)
    {
        $schema = new Schema;

        foreach ($definition as $fieldName => $field) {
            $this->addDefinedField($schema, $fieldName, $field);
        }

        return $schema;
    }

    /**
     * @param $type
     * @return FieldInterface
     * @throws Exception\SchemaException
     */
    private function createField($type)
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
                $property = new Backreference(substr($propertyValue, 1));
            } else {
                // Property is a straightforward value
                $property = new Property($propertyValue);
            }

            $this->setPropertyOnField($field, $propertyName, $property);
        }
    }

    /**
     * @param FieldInterface $field The field to assign the property on.
     * @param string $propertyName The name of the property to assign.
     * @param PropertyInterface $property The property value to assign.
     * @throws SchemaException
     */
    private function setPropertyOnField(FieldInterface $field, $propertyName, PropertyInterface $property)
    {
        // Try to use the setter
        $setterName = 'set' . ucfirst($propertyName);
        if (!method_exists($field, $setterName)) {
            throw new SchemaException(
                sprintf('Cannot find a setter on ', $propertyName, $setterName)
            );
        }

        $field->{$setterName}($property);
    }

    /**
     * @param Schema $schema
     * @param FieldInterface $field
     * @param $definition
     */
    private function addValidatorsToField(Schema $schema, FieldInterface $field, $definition)
    {
        // Set the validators on the field
        foreach ($definition as $validatorType => $validatorData) {
            $validator = $schema->createValidator($validatorType);
            $validator->setDesiredValue($validatorData);
            $field->addValidator($validator);
        }
    }

    /**
     * Add a new field to this schema instance, or to an existing CompoundField.
     *
     * @param Schema $schema The schema to add the field to.
     * @param string $fieldName The name of the field to add.
     * @param array $definition The definition (from JSON) of the field to add.
     * @param Compound $targetField The target compound field to add the new field to.
     */
    private function addDefinedField(Schema $schema, $fieldName, array $definition, Compound $targetField = null)
    {
        $newField = $this->createField($definition['_type']);

        // Assign the field name
        $newField->setName($fieldName);

        // Assign properties
        $this->addPropertiesToField($newField, $definition);

        // Assign validators
        if (isset($definition['_validators'])) {
            $this->addValidatorsToField($schema, $newField, $definition['_validators']);
        }

        // Are we adding a compound field?
        if (is_a($newField, __NAMESPACE__ . '\\Field\\Compound') &&
            isset($definition['_fields'])) {

            // Adding a compound field that has some subfields
            foreach ($definition['_fields'] as $subFieldName => $subFieldDefinition) {
                $this->addDefinedField($schema, $subFieldName, $subFieldDefinition, $newField);
            }
        }

        if ($targetField instanceof Compound) {
            // Adding the field to an existing compound field
            $targetField->addField($newField);
        } else {
            // Adding the field to this schema
            $schema->addField($newField);
        }
    }
}
