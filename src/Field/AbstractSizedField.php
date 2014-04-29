<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;

use Binary\Field\Property\PropertyInterface;

/**
 * SizedField
 * Abstract.
 *
 * Represents a field that is of a fixed (but not necessarily predefined) length.
 *
 * @since 1.0
 */
abstract class AbstractSizedField extends AbstractField
{
    /**
     * The size of the field.
     *
     * @protected PropertyInterface
     */
    protected $size;

    /**
     * @param PropertyInterface $size
     */
    public function setSize(PropertyInterface $size)
    {
        $this->size = $size;
    }

    /**
     * @return PropertyInterface
     */
    public function getSize()
    {
        return $this->size;
    }
}
