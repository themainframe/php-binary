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
 * Equal
 * Validator
 *
 * @since 1.0
 */
class Equal extends AbstractValidator
{
    /**
     * @param $input
     * @throws \Binary\Exception\ValidatorException
     */
    public function validate($input)
    {
        if ($input != $this->desiredValue) {
            throw new ValidatorException(
                'Field value is ' . $input . '. ' .
                'Must be equal to ' .
                $this->desiredValue
            );
        }
    }
}
