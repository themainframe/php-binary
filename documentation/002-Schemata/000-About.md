# Schemata

A *schema* (in php-binary land) describes the structure of a binary stream.

It is made up of a number of *fields*. These fields translate to array indices when php-binary parses a binary stream.

For clarity, here is an example schema described in English:

 1. **4 bytes** of text.
 2. followed by **1 byte** unsigned integer.
 3. followed by a field of **2 bytes** of text, followed by a **1 byte** unsigned integer;
    repeated `n` times, where `n` is a backreference to the byte described in point **2**.