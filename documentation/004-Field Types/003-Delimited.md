## Delimited

The `Delimited` type field reads from the stream until a known sequence of bytes appears.

This field type can be useful to skip ahead until a known pattern appears (I.e. for awaiting *training* sequences).

* The `delimiter` property defines the sequence of bytes marking the end of the field.
* The `searchLength` property defines the maximum number of bytes to read before stopping searching.

The writing context for this field is not yet implemented.