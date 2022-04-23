# dart-sass bridge in PHP

A wrapper for the `sass` binary so that you can use it in PHP code, without
needing to drag in a new node.js ecosystem into your project.

### What Problems Does This Solve?

- You don't need to pull in the node or dart ecosystem into your project just
  to write sass. 
- Existing PHP libraries for SASS do not support the latest dart-sass versions.
- Existing PHP libraries only support sass, or scss, not both.
- This is a tool to assist developers with live-compilation of sass, maybe your webserver
  serves css files but you want to "hot reload" on the fly in development.

### Keep your eyes on..

`sass-embedded` looks promising and might make this obsolete in the future.

## Installation

```
composer require --dev zarthus/sass-bridge
```

### Usage

```php
$sass = \Zarthus\Sass\SassBuilder::fromBinaryPath('/usr/bin/sass');

$result = $sass->getApi()->compileString('$red: red; h1 { color: $red; }');

echo $result->getCss();
// h1 {
//  color: red;
// }
```

```php
$sass = \Zarthus\Sass\SassBuilder::fromBinaryPath('/usr/bin/sass');

file_put_contents(__DIR__ . '/www/sass/main.scss', 'h1 { color: red; }');

$sass->getCli()->execute($sass->getCli()->createCommand(
    SassArgumentCollection::directory(__DIR__ . '/www/sass', __DIR__ . '/www/css'),
    (new \Zarthus\Sass\Cli\V1\Options\SassCliOptions())
        ->withStyle(\Zarthus\Sass\Cli\V1\Options\SassStyle::Compressed)
));

echo file_get_contents(__DIR__ . '/www/css/main.css');
// h1{color:red;}
```

### Testing

We use PHPUnit with integration + unit tests (`composer run test:*`), and psalm for static code analysis (`composer run psalm`).

#### Supported Versions

dart `sass` binaries of v1.4 and higher should work out of the box,
most functionality should still work on `sass` >= 1.0.



## License

Licensed under [MIT](LICENSE).
