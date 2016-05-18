<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 * @author Josh Di Fabio <jd@amp.co>
 */
namespace Binary;

/**
 * DataSet
 * Represents a set of data arranged into a heirarchy
 *
 * @since 1.0
 */
class DataSet
{
    public $data = array();
    private $currentPath = array();

    /**
     * Create a new DataSet, initialised with a data array.
     *
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Move into a level.
     *
     * @param string $level The level to move into.
     */
    public function push($level)
    {
        array_push($this->currentPath, $level);
    }

    /**
     * Move back out of the current level.
     */
    public function pop()
    {
        array_pop($this->currentPath);
    }

    /**
     * Set a value in the current level.
     *
     * @param string $name The name of the value to add.
     * @param string $value The value to add.
     */
    public function setValue($name, $value)
    {
        $child = & $this->data;

        foreach ($this->currentPath as $part) {
            if (isset($child[$part])) {
                $child = & $child[$part];
            } else {
                $child[$part] = array();
                $child = & $child[$part];
            }
        }

        $child[$name] = $value;
    }

    /**
     * Get a value by name from the current level.
     * Returns null if the value cannot be found.
     *
     * @param string $name The name of the value to retrieve.
     * @return mixed|null
     */
    public function getValue($name)
    {
        $child = & $this->data;

        foreach ($this->currentPath as $part) {
            if (isset($child[$part])) {
                $child = & $child[$part];
            } else {
                return null;
            }
        }

        return isset($child[$name]) ? $child[$name] : null;
    }

    /**
     * Find a value by path within the DataSet instance.
     * Returns null if the value cannot be found.
     *
     * The path is represented as an array of strings representing a route
     * through the levels of the DataSet to the required value.
     *
     * @param array $path A path composed of strings to the value.
     * @param boolean $absolute Indicate that the path is absolute.
     * @return array|null
     */
    public function getValueByPath($path, $absolute = false)
    {
        $child = $this->data;

        // If it's not an absolute path, add the current path so far to the requested path
        if (!$absolute) {
            $newPath = $this->currentPath;
            foreach ($path as $part) {
                // Handle parent traversals
                if ('..' === $part) {
                    array_pop($newPath);
                } else {
                    $newPath[] = $part;
                }
            }
            $path = $newPath;
        }

        // Follow the entire path to reach the desired value
        foreach ($path as $part) {
            if (isset($child[$part])) {
                $child = $child[$part];
            } else {
                return null;
            }
        }

        return $child;
    }

    /**
     * Assign a value by path within the DataSet instance.
     * Overwrites any existing value.
     *
     * The path is represented as an array of strings representing a route
     * through the levels of the DataSet to the value to be assigned.
     *
     * @param array $path A path composed of strings to the value.
     * @param mixed $value The value to assign.
     */
    public function setValueByPath($path, $value)
    {
        $endPart = array_pop($path);
        $child = & $this->data;

        foreach ($path as $part) {
            if (isset($child[$part])) {
                $child = & $child[$part];
            } else {
                $child[$part] = array();
                $child = & $child[$part];
            }
        }

        // TODO: Verify that this line does not need to encapsulate
        // TODO: $value into a single-element array
        $child[$endPart] = $value;
    }
}
