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
     * Attach a validator to the field.
     *
     * @param AbstractValidator $validator
     */
    public function addValidator(AbstractValidator $validator)
    {
        $this->validators[] = $validator;
    }

    /**
     * Check that the field is currently valid.
     */
    public function validate($value)
    {
        try {
            foreach ($this->validators as $validator) {
                $validator->validate($value);
            }
        } catch (ValidatorException $exception) {

            // Re-throw with field information
            throw new \Exception(
                'Field ' . $this->name . ' failed validation: ' .
                $exception->getMessage()
            );

        }
    }
}
