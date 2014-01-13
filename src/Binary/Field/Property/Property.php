<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field\Property;

use Binary\DataSet;

/**
 * Property
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

    public function get(DataSet $result)
    {
        return $this->value;
    }
}
