<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package  php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;

use Binary\Stream\StringStream;

/**
 * StringStreamTest
 *
 * @since 1.0
 */
class StringStreamTest extends AbstractFieldTest
{
    /**
     * Read a single byte from the string stream.
     *
     * @covers \Binary\Stream\StringStream::__construct
     * @covers \Binary\Stream\StringStream::readByte
     */
    public function testReadSingleByte()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertEquals('a', $stringStream->readByte());
    }

    /**
     * Read multiple bytes from the string stream.
     *
     * @covers \Binary\Stream\StringStream::read
     */
    public function testReadMultipleBytes()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertEquals('abc', $stringStream->read(3));
    }

    /**
     * Check the position of the stream after a read.
     *
     * @covers \Binary\Stream\StringStream::getPosition
     */
    public function testCheckPositionAfterRead()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertEquals('abc', $stringStream->read(3));
        $this->assertEquals(3, $stringStream->getPosition());
    }

    /**
     * Read past the end of the stream.
     *
     * @covers \Binary\Stream\StringStream::read
     */
    public function testReadPastEndOfAvailableBytes()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertEquals('abcdefg', $stringStream->read(25));
    }

    /**
     * Read bytes once we're already at the end of the stream.
     *
     * @covers \Binary\Stream\StringStream::read
     */
    public function testReadBytesWhenAlreadyPastEndOfAvailableBytes()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertEquals('abcdefg', $stringStream->read(7));
        $this->assertEquals(false, $stringStream->read(1));
    }

    /**
     * Write a single byte.
     *
     * @covers \Binary\Stream\StringStream::writeByte
     * @covers \Binary\Stream\StringStream::getString
     */
    public function testWriteSingleByte()
    {
        $stringStream = new StringStream('');
        $stringStream->writeByte('a');
        $this->assertEquals('a', $stringStream->getString());
    }


    /**
     * Write multiple bytes.
     *
     * @covers \Binary\Stream\StringStream::write
     * @covers \Binary\Stream\StringStream::getString
     */
    public function testWriteMultipleBytes()
    {
        $stringStream = new StringStream('');
        $stringStream->write('abcdefg');
        $this->assertEquals('abcdefg', $stringStream->getString());
    }

    /**
     * Check that closing a StringStream works.
     *
     * @covers \Binary\Stream\StringStream::close
     */
    public function testClosingStream()
    {
        $stringStream = new StringStream('abcdefg');
        $this->assertTrue($stringStream->close());
    }
}
