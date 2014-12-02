## Creation Using SchemaBuilder

The simplest way to define a schema in php-binary is to use the `SchemaBuilder` class.

`SchemaBuilder` has a `createFromArray` method that takes an array that describes the schema to be created:

```php
$sb = new \Binary\SchemaBuilder();
$sc = $sb->createFromArray(array(
    'protocol' => array(
        '_type' => 'Text',
        'size' => 4
    )
));
```

Typically the schema will be described as JSON or XML and converted to an array before being given to `SchemaBuilder::createFromArray`.

Each field derives it's name from the associative array key.

Each field has a number of "internal" properties that begin with an `_`. These properties are:

* `_type` - The classname of the field.
* `_fields` - For `Compound` type fields, an associative array of the enclosed fields.
* `_validators` - Any validators to associate with the field.

## Creation Without SchemaBuilder

Under the hood, `SchemaBuilder` uses a number of Fluent Interfaces to define a schema.

You can opt to use these too if you wish:

```php
$schema = new Binary\Schema;
$schema->addField(
    $schema->createField('Text')
        ->setName('protocol')
        ->setSize(new \Binary\Field\Property\Property(4))
);
```
