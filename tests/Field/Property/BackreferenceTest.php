<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;
use Binary\Field\Property\Backreference;


/**
 * BackreferenceTest
 */
class BackreferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that absolute paths are identified correctly.
     *
     * @covers \Binary\Field\Property\Backreference::get
     */
    public function testAbsolutePathHandling()
    {
        $property = new Backreference('/foo/bar/some/path');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('getValueByPath')
            ->with($this->equalTo(array('foo', 'bar', 'some', 'path')), true);

        $property->get($dataSet);
    }

    /**
     * Tests that relative paths are identified correctly.
     *
     * @covers \Binary\Field\Property\Backreference::get
     */
    public function testRelativePathHandling()
    {
        $property = new Backreference('foo/bar/other/path');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('getValueByPath')
            ->with($this->equalTo(array('foo', 'bar', 'other', 'path')), false);

        $property->get($dataSet);
    }


}
