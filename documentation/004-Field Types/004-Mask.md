## Mask

The `Mask` field type is used to extract bitwise portions of a single byte from a stream.

* The `structure` property of this field defines the structure of the mask to apply.

The writing context for this field is not yet implemented.

### Example

For example, an RGBA (Red, Green, Blue, Alpha Channel) colour can be represented (with very low precision!) as one byte:

* 2 bits for Red
* 2 bits for Green
* 2 bits for Blue
* 2 bits for Alpha Channel

To read a colour in this format from a stream, a schema may have the following field defined:

    $colour = $schema->createField('Mask')
        ->setName('colour')
        ->setStructure(new Property(array(

            'red' => 2,
            'green' => 2,
            'blue' => 2,
            'alpha' => 2

        ));