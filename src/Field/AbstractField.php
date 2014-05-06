<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Exception\ValidatorException;
use Binary\Validator\AbstractValidator;

/**
 * Field
 * Abstract.
 *
 * @since 1.0
 */
abstract class AbstractField implements FieldInterface
{
    /**
     * @public Binary\AbstractValidator[] Validators attached to the field.
     */
    private $validators = array();

    /**
     * @public string The name of the field.
     */
    public $name = '';

    /**
     * Set the name of this field.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name of this field.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Attach a validator to the field.
     *
     * @param AbstractValidator $validator
     * @return $this
     */
    public function addValidator(AbstractValidator $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Check that the field is currently valid.
     *
     * @param mixed $value The actual value of the field that has been read.
     * @throws ValidatorException
     */
    public function validate($value)
    {
        try {
            foreach ($this->validators as $validator) {
                $validator->validate($value);
            }
        } catch (ValidatorException $exception) {

            // Re-throw with field information
            throw new ValidatorException(
                'Field ' . $this->name . ' failed validation: ' .
                $exception->getMessage()
            );

        }
    }
}
