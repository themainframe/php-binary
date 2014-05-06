php-binary [![Build Status](https://travis-ci.org/themainframe/php-binary.svg?branch=master)](https://travis-ci.org/themainframe/php-binary)
==========

A PHP library for parsing structured binary streams.

## Documentation

Documentation can be found in the `documentation` directory, as well as online at [http://php-binary.damow.net](php-binary.damow.net)

## Usage

Here is an example binary format:

 1. **4 bytes** of text.
 2. **1 byte** unsigned integer.
 3. A field of **2 bytes** of text followed by a **1 byte** unsigned integer; repeated *n* times, where *n* is a backreference to the byte described in point **2**.


### Writing a Parser Schema

This format can be parsed as follows. In this example, the schema is described using JSON for clarity, though in practise any array may be used.

    $schema = new Binary\Schema;
    $schema->initWithArray(json_decode('

        {
           "sometext": {
               "_type": "Text",
               "size": 4
           },
           "somebyte": {
               "_type": "UnsignedInteger",
               "size": 1
           },
           "somefields": {
               "_type": "Compound",
               "count": "@somebyte",
               "_fields": {
                   "footext": {
                       "_type": "Text",
                       "size": 2
                   },
                   "foobyte": {
                       "_type": "UnsignedInteger",
                       "size": 1
                   }
               }
           }
        }

    ', true));

### Parsing a Stream

You can have php-binary parse a generic stream of bytes and output fields as an associative array matching your schema definition.

    $stream = new Binary\Stream\StringStream("FOOO\x03LOLLOMLON");
    $result = $schema->readStream($stream);

The resulting associative array in `$result` (shown here as JSON for clarity) would contain:

    {
        "sometext": "FOOO",
        "somebyte": 3,
        "somefields": [
            {
                "footext": "LO",
                "foobyte": 76
            },
            {
                "footext": "LO",
                "foobyte": 77
            },
            {
                "footext": "LO",
                "foobyte": 78
            }
        ]
    }
