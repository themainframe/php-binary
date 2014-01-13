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
 * Backreference
 * Represents a backreference to a previously-read value
 *
 * @since 1.0
 */
class Backreference extends Property
{
    private $path = '';


    public function __construct()
    {

    }

    /**
     * Get the value for the property
     *
     * @param DataSet $result
     * @return array|null
     */
    public function get(DataSet $result)
    {
        $pathParts = explode('/', $this->path);
        return $result->getValueByPath($pathParts);
    }

    /**
     * @param string $path The path to the backreferenced result value.
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
