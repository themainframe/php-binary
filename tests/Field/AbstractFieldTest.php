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
 * AbstractFieldTest
 */
abstract class AbstractFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Produces a mocked PropertyInterface that wraps $value.
     *
     * @param $value
     * @return \Binary\Field\Property\PropertyInterface
     */
    public function getMockedProperty($value)
    {
        $property = $this->getMockBuilder('\Binary\Field\Property\PropertyInterface')->getMock();
        $property->expects($this->any())
            ->method('get')
            ->will($this->returnValue($value));

        return $property;
    }

    /**
     * Produces a mocked StringStream that wraps $value.
     *
     * @param $value
     * @return \Binary\Stream\StringStream
     */
    public function getMockedStringStream($value)
    {
        $stream = $this->getMock('\Binary\Stream\StreamInterface');
        $stream->expects($this->any())
            ->method('read')
            ->will($this->returnValue($value));
        
        return $stream;
    }
}
