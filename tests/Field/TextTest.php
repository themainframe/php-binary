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
use Binary\Stream\StringStream;

/**
 * TextTest
 *
 * @since 1.0
 */
class TextTest extends AbstractFieldTest
{
    /**
     * Test a simple read.
     *
     * @covers \Binary\Field\Text::read
     */
    public function testSimpleRead()
    {
        $field = new Text();
        $field->setSize($this->getMockedProperty(4));
        $field->setName('foo');

        $stream = $this->getMockedStringStream('barr');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo('barr'));

        $field->read($stream, $dataSet);
    }

    /**
     * Test a simple write.
     *
     * @covers \Binary\Field\Text::write
     */
    public function testSimpleWrite()
    {
        $field = new Text();
        $field->setName('foo');
        $field->setSize($this->getMockedProperty(7));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->any())
            ->method('getValue')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue('abcdefg'));

        $stream = new StringStream('');
        $field->write($stream, $dataSet);

        $this->assertEquals('abcdefg', $stream->getString());
    }

    /**
     * Test a write that is shorter than the available data.
     *
     * @covers \Binary\Field\Text::write
     */
    public function testShortWrite()
    {
        $field = new Text();
        $field->setName('foo');
        $field->setSize($this->getMockedProperty(5));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->any())
            ->method('getValue')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue('abcdefg'));

        $stream = new StringStream('');
        $field->write($stream, $dataSet);

        $this->assertEquals('abcde', $stream->getString());
    }
}
