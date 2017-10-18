# Simple Jigsaw

Simple Jigsaw is opensource jigsaw game on web platform, the application is backed by Laravel 5.1 and can be easily extended using **Laravel** integration.

Online Demo link: [live demo](http://jigsawpuzzle1.com)

## Requirements

- PHP >=5.4
- Fileinfo Extension
- Intervention Image

## Supported Image Libraries

- GD Library (>=2.0)
- Imagick PHP extension (>=6.5.7)

## Getting started

- [Installation](http://image.intervention.io/getting_started/installation)
- [Laravel Framework Integration](http://image.intervention.io/getting_started/installation#laravel)
- [Basic Usage](http://image.intervention.io/use/basics)

## Code Examples

```php
// open an image file
$img = Image::make('public/foo.jpg');

// resize image instance
$img->resize(320, 240);

// insert a watermark
$img->insert('public/watermark.png');

// save image in desired format
$img->save('public/bar.jpg');
```

Refer to the [official documentation](http://image.intervention.io/) to learn more about Intervention Image.

## Contributing

Contributions to the Intervention Image library are welcome. Please note the following guidelines before submiting your pull request.

- Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) coding standards.
- Write tests for new functions and added features
- API calls should work consistently with both GD and Imagick drivers

## License

Simple Jigsaw is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2017 [Dzung Cao] - dungcaond@gmail.com
