# Bag

*Bag* is a simple parameter bag class to make working with arrays easier.

[![Build Status](https://travis-ci.org/adamnicholson/bag.svg?branch=master)](https://travis-ci.org/adamnicholson/bag)

## Motivation
Boilerplate `isset` calls whenever working with arrays can be a pain.

```php
function foo (array $data) {
    if (!isset($data['status']) || !isset($data['data']['foo'])) || $data['status'] !== 'success') {
        return false;
    }
    return $data['data']['foo'];
}

// vs

function bar (array $data) {
    $data = new Bag($data);

    if ($bag->get('status') !== 'success') {
        return false;
    }

    return $bag->get('data.foo');
}
```

> Note: `isset` boilerplate will hopefully be much less of a chore in PHP7 with the [isset ternary operator](https://wiki.php.net/rfc/isset_ternary)

## Usage

```php
$array = [
    'foo' => 'bar',
    'hello' => 'world',
    'items' => [
        'first' => 'fizz',
        'second' => 'buzz'
    ]
];

$bag = new Adam\Bag\Bag($array);

// Get a value by key
$bag->get('foo'); // string "bar"

// Set some value by key
$bag->set('fizz', 'buzz');

// Return a default value if the key is not set
$bag->get('ziff'); // null
$bag->get('ziff', 'my_default_value'); // string "my_default_value"

// Use dot notation for multidimensional arrays
$bag->get('items.first'); // string "fizz"
$bag->set('items.third', 'foovalue');

// Get the value of an item and then remove it
$bag->pluck('foo'); // string "bar"
$bag->get('foo'); // null

// Get the raw data
$bag->all(); // array

// Empty the data
$bag->flush();
```

## Contributing

We welcome any contributions to this project. They can be made via GitHub issues or pull requests.

## License

This project is licensed under the MIT License - see the `LICENSE.txt` file for details

## Author

Adam Nicholson - adamnicholson10@gmail.com
