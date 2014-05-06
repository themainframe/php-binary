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
 * SchemaTest
 *
 * @todo Add more cases to examine the object graph generated from
 * @todo specific schemas.
 * @since 1.0
 */
class SchemaTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $schema = new Schema();
        $schema->addField(new Text());
        $schema->addField(new Text());

        // Inspect the schema
        $this->assertArrayHasKey(0, $schema->fields);
        $this->assertArrayHasKey(0, $schema->fields);
    }
}
