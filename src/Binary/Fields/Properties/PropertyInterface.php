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
 * PropertyInterface
 * Specifies the interface for properties associated with a field
 *
 * @since 1.0
 */
interface PropertyInterface
{
    public function get(Result $result);
}
