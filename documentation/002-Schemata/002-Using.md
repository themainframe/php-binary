## Using Schemata

Schemata can be used to either read or write from or to a `StreamInterface`-implementing object.

### Reading

Given a schema object, `$schema`, a stream can be read and parsed. A `StringStream` instance is used here as an example:

    $stream = new \Binary\Stream\StringStream("FOOO\x03LOLLOMLON");
    $result = $schema->readStream($stream);


### Writing

Given a schema object, `$schema`, and an array of data, `$data`, a stream can be written.

The data array should be a key-value array of field names and values.

A `StringStream` instance is used here as an example:

    $stream = new \Binary\Stream\StringStream();
    $dataSet = new \Binary\DataSet($data);
    $schema->writeStream($stream, $dataSet);