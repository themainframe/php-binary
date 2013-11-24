<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Fields\Properties;
use Binary\Result;

/**
 * Property
 * Abstract
 *
 * @since 1.0
 */
class Property implements PropertyInterface
{
    /**
     * @private mixed The underlying value.
     */
    private $value = null;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function get(Result $result)
    {
        return $this->value;
    }
}
