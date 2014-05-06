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

    /**
     * @param string $path The path to resolve for this backreference
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Get the value of the property for the given DataSet.
     *
     * @param DataSet $result
     * @return mixed
     */
    public function get(DataSet $result)
    {
        // If the path begins '/', it is absolute
        $absolute = isset($this->path[0]) && $this->path[0] === '/';

        $pathParts = explode('/', $this->path);
        if ($absolute) {
            array_shift($pathParts);
        }

        return $result->getValueByPath($pathParts, $absolute);
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
