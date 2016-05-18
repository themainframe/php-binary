<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Field\UnsignedInteger;
use Binary\Stream\StringStream;

/**
 * UnsignedIntegerTest
 *
 * @since 1.0
 */
class UnsignedIntegerTest extends AbstractFieldTest
{
    /**
     * Tests a simple read.
     *
     * @covers \Binary\Field\UnsignedInteger::read
     */
    public function testSimpleRead()
    {
        $field = new UnsignedInteger();
        $field->setSize($this->getMockedProperty(1));
        $field->setName('foo');

        $stream = $this->getMockedStringStream("\x03");

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo(3));

        $field->read($stream, $dataSet);
    }

    /**
     * Tests a simple write.
     *
     * @covers \Binary\Field\UnsignedInteger::write
     */
    public function testSimpleWrite()
    {
        $field = new UnsignedInteger();
        $field->setName('foo');
        $field->setSize($this->getMockedProperty(1));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->any())
            ->method('getValue')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue(7));

        $stream = new StringStream('');
        $field->write($stream, $dataSet);

        $this->assertEquals("\x07", $stream->getString());
    }

    /**
     * Tests a write where the field is smaller than the available data can be represented inside.
     *
     * @covers \Binary\Field\UnsignedInteger::write
     */
    public function testShortWrite()
    {
        $field = new UnsignedInteger();
        $field->setName('foo');
        $field->setSize($this->getMockedProperty(1));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->any())
            ->method('getValue')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue(256));

        $stream = new StringStream('');
        $field->write($stream, $dataSet);

        $this->assertEquals("\x00", $stream->getString());
    }
}
