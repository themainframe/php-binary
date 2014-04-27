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

    /**
     * @param mixed $value The value of the new property.
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of the property for the given DataSet.
     *
     * @param DataSet $result
     * @return mixed
     */
    public function get(DataSet $result)
    {
        return $this->value;
    }
}
