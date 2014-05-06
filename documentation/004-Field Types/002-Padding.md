## Padding

The `Padding` type field does not produce any values in the result `DataSet`.

It can be used to skip over a number of bytes in the stream.

* The `size` property defines the number of bytes to consume/write.

When writing, `Padding` type fields will emit `NUL` bytes into the stream.