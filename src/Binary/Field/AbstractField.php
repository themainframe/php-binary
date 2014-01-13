<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

/**
 * Field
 * Abstract.
 *
 * @since 1.0
 */
abstract class AbstractField implements FieldInterface
{
    /**
     * @public string $name The name of the field.
     */
    public $name = '';
}
