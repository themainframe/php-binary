## Compound

The `Compound` field type is a special type that represents a sequence of fields.

A Compound field by itself generates no output while writing and reads no bytes while reading.

Compound fields are useful to better structure the output array from a parsed binary stream.

* The `count` property defines how many times the compound field should be repeated. The default is once (1).

### Example

A compound field can have any number of subfields, which may include other compound fields.

Given a simple schema:

1. A single unsinged integer byte of value `n`.
2. Followed by an ASCII text field of length `n`.
3. *...all repeated 10 times.*

The following php-binary schema could be created:

    $schema = new Binary\Schema()

        ->addField(

            $schema->createField('Compound')

                // Set the name and the number of repetitions (point 3 above)
                ->setName('group')
                ->setCount(new Property(10))

                // Add the fields (points 1 and 2 above)
                ->addField(
                    $schema->createField('UnsignedInteger')
                        ->setName('size')
                        ->setSize(new Property(1))
                )
                ->addField(
                    $schema->createField('Text')
                        ->setName('text')
                        ->setSize(new Backreference('size'))
                )
        )

    ;