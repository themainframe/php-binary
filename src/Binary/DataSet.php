<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
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

    public function push($level)
    {
        array_push($this->currentPath, $level);
    }

    public function pop()
    {
        array_pop($this->currentPath);
    }

    public function addValue($name, $value)
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

    public function findValueByPath($path)
    {
        $child = $this->data;

        foreach ($path as $part) {
            if (isset($child[$part])) {
                $child = $child[$part];
            } else {
                return null;
            }
        }

        return $child;
    }

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

        $child[$endPart] = array($value);
    }
}
