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
 * PropertyInterface
 * Specifies the interface for properties associated with a field
 *
 * @since 1.0
 */
interface PropertyInterface
{
    public function get(DataSet $result);
}
