## Built-In Stream Types

php-binary includes a few built-in stream types:

### StringStream

`StringStream` is a stream backed by a regular PHP string.

### FileStream

`FileStream` is a stream backed by a PHP file resource.

Any file that can be opened natively using `fopen()` can be wrapped with a `FileStream` instance.

### TcpStream

`TcpStream` is a stream backed by a TCP socket.