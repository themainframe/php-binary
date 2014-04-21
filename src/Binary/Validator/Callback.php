<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Validator;

use Binary\Exception\ValidatorException;

/**
 * Callback
 * Validator
 *
 * Executes a callback for each validate() call that can determine if the value of the field is suitable.
 *
 * The value of the field being validated will be provided as the first argument to the callback.
 *
 * If validation succeeds, the callback should return boolean true. All other return values will be converted to a
 * ValidatorException instance and thrown.
 *
 * @since 1.0
 */
class Callback extends AbstractValidator
{
    /**
     * @param $input
     * @throws \Binary\Exception\ValidatorException
     */
    public function validate($input)
    {
        if (is_callable($this->desiredValue)) {

            $result = call_user_func($this->desiredValue, $input);

            if ($result !== true) {
                throw new ValidatorException($result);
            }
        }
    }
}
