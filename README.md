<p align="center">
    <a href="https://github.com/php-ffi-headers">
        <img src="https://avatars.githubusercontent.com/u/101121010?s=256" width="128" />
    </a>
</p>

<p align="center">
    <a href="https://github.com/php-ffi-headers/sdl2-image-headers/actions"><img src="https://github.com/php-ffi-headers/sdl2-image-headers/workflows/build/badge.svg"></a>
    <a href="https://packagist.org/packages/ffi-headers/sdl2-image-headers"><img src="https://img.shields.io/badge/PHP-8.1.0-ff0140.svg"></a>
    <a href="https://packagist.org/packages/ffi-headers/sdl2-image-headers"><img src="https://img.shields.io/badge/SDL2%20Image-2.6.1-cc3c20.svg"></a>
    <a href="https://packagist.org/packages/ffi-headers/sdl2-image-headers"><img src="https://poser.pugx.org/ffi-headers/sdl2-image-headers/version" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/ffi-headers/sdl2-image-headers"><img src="https://poser.pugx.org/ffi-headers/sdl2-image-headers/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://packagist.org/packages/ffi-headers/sdl2-image-headers"><img src="https://poser.pugx.org/ffi-headers/sdl2-image-headers/downloads" alt="Total Downloads"></a>
    <a href="https://raw.githubusercontent.com/php-ffi-headers/sdl2-image-headers/master/LICENSE.md"><img src="https://poser.pugx.org/ffi-headers/sdl2-image-headers/license" alt="License MIT"></a>
</p>

# SDL2 Image Headers

This is a C headers of the [SDL2 Image](https://www.libsdl.org/projects/SDL_image) adopted for PHP.

## Requirements

- PHP >= 8.1

## Installation

Library is available as composer repository and can be installed using the
following command in a root of your project.

```sh
$ composer require ffi-headers/sdl2-image-headers
```

## Usage

```php
use FFI\Headers\SDL2Image;

$headers = SDL2Image::create(
    SDL2Image\Version::V2_0_5,
);

echo $headers;
```

> Please note that the use of header files is not the latest version:
> - Takes time to download and install (This will be done in the background
    >   during initialization).
> - May not be compatible with the PHP headers library.

