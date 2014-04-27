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
 * DataSetTest
 *
 * @since 1.0
 */
class DataSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Binary\DataSet::setValue
     */
    public function testFlatSetValue()
    {
        $dataSet = new DataSet();
        $dataSet->setValue('foo', 'bar');

        $this->assertArrayHasKey('foo', $dataSet->data);
        $this->assertEquals('bar', $dataSet->data['foo']);
        $this->assertCount(1, $dataSet->data);
    }

    /**
     * @covers Binary\DataSet::getValue
     */
    public function testFlatGetValue()
    {
        $dataSet = new DataSet();
        $dataSet->setValue('foo', 'bar');

        $this->assertEquals('bar', $dataSet->getValue('foo'));
    }

    /**
     * @covers Binary\DataSet::getValueByPath
     */
    public function testFlatGetValueByPath()
    {
        $dataSet = new DataSet();
        $dataSet->setValue('foo', 'bar');

        $this->assertEquals('bar', $dataSet->getValueByPath(array('foo')));
    }

    /**
     * @covers Binary\DataSet::setValueByPath
     */
    public function testFlatSetValueByPath()
    {
        $dataSet = new DataSet();
        $dataSet->setValueByPath(array('foo'), 'bar');

        $this->assertEquals('bar', $dataSet->getValueByPath(array('foo')));
    }

    /**
     * @covers Binary\DataSet::push
     */
    public function testNestedSetValue()
    {
        $dataSet = new DataSet();
        $dataSet->push('level1');
        $dataSet->setValue('foo', 'bar');

        $this->assertEquals(array(
            'level1' => array(
                'foo' => 'bar'
            )
        ), $dataSet->data);
    }

    /**
     * @covers Binary\DataSet::getValue
     */
    public function testNestedGetValue()
    {
        $dataSet = new DataSet();
        $dataSet->push('level1');
        $dataSet->setValue('foo', 'bar');

        $this->assertEquals('bar', $dataSet->getValue('foo'));
    }

    /**
     * @covers Binary\DataSet::getValueByPath
     */
    public function testNestedGetValueByPath()
    {
        $dataSet = new DataSet();
        $dataSet->push('level1');
        $dataSet->setValue('foo', 'bar');

        $this->assertEquals('bar', $dataSet->getValueByPath(array('level1', 'foo')));
    }

    /**
     * @covers Binary\DataSet::setValueByPath
     */
    public function testNestedSetValueByPath()
    {
        $dataSet = new DataSet();
        $dataSet->setValueByPath(array('level1', 'foo'), 'bar');

        $this->assertEquals('bar', $dataSet->getValueByPath(array('level1', 'foo')));
    }
}
