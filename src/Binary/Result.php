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
 * Result
 * Represents a result produced by parsing a schema.
 *
 * @since 1.0
 */
class Result
{
    public $values = array();
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
        $child = & $this->values;

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
        $child = $this->values;

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
        $child = & $this->values;

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
