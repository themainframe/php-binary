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
 * SchemaBuilderTest
 *
 * @since 1.0
 */
class SchemaBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the creation of a simple schema with one field.
     */
    public function testBuildSingleField()
    {
        $builder = new SchemaBuilder();
        $schema = $builder->createFromArray(array(
            'sometext' => array(
                '_type' => 'text',
                'size' => 4
            )
        ));

        $this->assertCount(1, $schema->getFields());

        $field = $schema->getFields()[0];

        $this->assertInstanceOf('\Binary\Field\FieldInterface', $field);
        $this->assertEquals('sometext', $field->getName());
    }
}
