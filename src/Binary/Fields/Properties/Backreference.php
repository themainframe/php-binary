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

    public function get(Result $result)
    {
        $pathParts = explode('/', $this->path);
        return $result->findValueByPath($pathParts);
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
