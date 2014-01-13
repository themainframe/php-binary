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
 * SchemaTest
 *
 * @todo Add more cases to examine the object graph generated from
 * @todo specific schemas.
 * @since 1.0
 */
class SchemaTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleInitWithArray()
    {
        $schema = new Schema();
        $schema->initWithArray(array(
            'foo' => array(
                '_type' => 'Text',
                'size' => 4
            )
        ));

        // Inspect the schema
        $this->assertArrayHasKey(0, $schema->fields);
        $this->assertArrayHasKey(0, $schema->fields);
    }
}
