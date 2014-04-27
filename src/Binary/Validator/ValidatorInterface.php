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
 * ValidatorInterface
 * Describes the interface for a field validator.
 *
 * @since 1.0
 */
interface ValidatorInterface
{
    /**
     * @param mixed $input The value that should be validated
     * @throws ValidatorException
     */
    public function validate($input);
}
