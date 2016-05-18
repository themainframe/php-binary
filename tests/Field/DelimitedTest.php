<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Field\Delimited;
use Binary\Stream\StringStream;

/**
 * DelimitedTest
 *
 * @since 1.0
 */
class DelimitedTest extends AbstractFieldTest
{
    /**
     * Test a simple read.
     *
     * @covers \Binary\Field\Delimited::read
     */
    public function testSimpleRead()
    {
        $field = new Delimited();
        $field->setName('foo');
        $field->setDelimiter($this->getMockedProperty(','));

        $stream = new StringStream('abcdefg,hijkl');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo('abcdefg'));
        $field->read($stream, $dataSet);
    }

    /**
     * Test a read when the delimiter has multiple characters.
     *
     * @covers \Binary\Field\Delimited::read
     */
    public function testMultiCharacterDelimiterRead()
    {
        $field = new Delimited();
        $field->setName('foo');
        $field->setDelimiter($this->getMockedProperty('<-->'));

        $stream = new StringStream('fur<-->aff');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo('fur'));
        $field->read($stream, $dataSet);
    }

    /**
     * Test a read where the delimiter never appears.
     *
     * @covers \Binary\Field\Delimited::read
     */
    public function testNeverReachesDelimiterRead()
    {
        $field = new Delimited();
        $field->setName('foo');
        $field->setDelimiter($this->getMockedProperty(','));
        $field->setSearchLength($this->getMockedProperty(10));

        $stream = new StringStream('aaaaaaaaaaaaaaa');

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->once())
            ->method('setValue')
            ->with($this->equalTo('foo'), $this->equalTo('aaaaaaaaaa'));
        $field->read($stream, $dataSet);
    }

    /**
     * Test a simple write.
     *
     * @covers \Binary\Field\Delimited::write
     */
    public function testSimpleWrite()
    {
        $field = new Delimited();
        $field->setName('foo');
        $field->setDelimiter($this->getMockedProperty(','));
        $field->setSearchLength($this->getMockedProperty(10));

        $dataSet = $this->getMock('\Binary\DataSet');
        $dataSet->expects($this->any())
            ->method('getValue')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue('abcdefg'));

        $stream = new StringStream('');
        $field->write($stream, $dataSet);

        $this->assertEquals('abcdefg,', $stream->getString());
    }
}
