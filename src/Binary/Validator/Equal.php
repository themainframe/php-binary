<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Validator;

/**
 * Equal
 * Validator
 *
 * @since 1.0
 */
class Equal extends AbstractValidator
{
    public function validate($input)
    {
        if ($input != $this->desiredValue) {
            throw new \Exception('Fail!');
        }
    }
}
