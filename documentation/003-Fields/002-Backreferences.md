## Backreferences

Backreferences are a type of property.

They are properties whose values are derived from previously-parsed fields.

A common trait in structured binary streams is to have a byte indicate how long the following field is. For example, a structure might have a single unsigned integer byte that dictates how long the following ASCII text field is in bytes.

In this situation, the following schema could be defined:

```php
$schema

    // 1 byte unsigned integer
    ->addField(
        $schema->createField('UnsignedInteger')
            ->setName('length')
            ->setSize(new Property(1))
    )

    // n bytes of ASCII text
    ->addField(
        $schema->createField('Text')
            ->setName('sometext')
            ->setSize(new Backreference('length'))
    )

;
```

Backreferences can refer to any previously-read field value. Values inside compound fields can be reached using `/` to separate field names.

Backreferences are assumed to be relative to the current field. Absolute backreferences can be obtained by prefixing a backreference string with a `/`. For example, a field `val` nested inside two compound fields `comp_a` and `comp_b` could be backreferenced by `/comp_a/comp_b/val`.

Relative backreferences may refer to parent fields, for example, a field `foo` nested inside two compound fields `comp_a` and `comp_b` could access a sibling field of `comp_b` - `bar` -  with the backreference `../bar`:

    * `comp_a` -----> * `comp_b` -----> * `foo`
                      * `bar`
