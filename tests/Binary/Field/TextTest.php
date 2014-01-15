<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Field\Text;

/**
 * TextTest
 *
 * @since 1.0
 */
class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleRead()
    {
        $field = new Text();

        $property = $this->getMock('\Binary\Property\Property', array('get'));
        $property->expects($this->any())
            ->method('get')
            ->will($this->returnValue(4));

        $field->size= $property;
        $field->name = 'foo';

        $stream = $this->getMock('\Binary\Stream\StreamInterface');
        $stream->expects($this->any())
            ->method('read')
            ->will($this->returnValue('barr'));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo('barr'));

        $field->read($stream, $dataSet);
    }
}
