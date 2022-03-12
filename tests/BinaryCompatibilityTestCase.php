<?php

/**
 * This file is part of FFI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FFI\Headers\SDL2Image\Tests;

use FFI\Env\Runtime;
use FFI\Headers\SDL2Image;
use FFI\Headers\SDL2Image\Tests\BinaryCompatibilityTestCase\Downloader;
use FFI\Headers\SDL2Image\Version;
use FFI\Location\Locator;

class BinaryCompatibilityTestCase extends TestCase
{
    private const DIR_STORAGE = __DIR__ . '/storage';

    /**
     * @requires OSFAMILY Windows
     *
     * @dataProvider configDataProvider
     */
    public function testWindowsBinaryCompatibility(Version $version): void
    {
        if (!\is_file(self::DIR_STORAGE . '/SDL2.dll')) {
            Downloader::download(\vsprintf('https://www.libsdl.org/release/SDL2-2.0.10-win32-x64.zip', [
                $version->toString()
            ]))
                ->extract('SDL2.dll', self::DIR_STORAGE . '/SDL2.dll');
        }

        if (!\is_file(self::DIR_STORAGE . '/SDL2_image.dll')) {
            Downloader::download('https://www.libsdl.org/projects/SDL_image/release/SDL2_image-2.0.5-win32-x64.zip')
                ->extract('SDL2_image.dll', self::DIR_STORAGE . '/SDL2_image.dll');
        }

        $this->assertHeadersCompatibleWith(
            SDL2Image::create($version),
            self::DIR_STORAGE . '/SDL2_image.dll'
        );
    }

    /**
     * @requires OSFAMILY Darwin
     *
     * @dataProvider configDataProvider
     */
    public function testDarwinBinaryCompatibility(Version $version): void
    {
        if (!Locator::exists('libSDL2_image-2.0.0.dylib')) {
            $this->markTestSkipped('sdl2_image not installed');
        }

        $headers = (string)SDL2Image::create($version);

        try {
            \FFI::cdef($headers, Locator::resolve('libSDL2_image-2.0.0.dylib'));
        } catch (\FFI\ParserException $e) {
            $this->dumpExceptionInfo($e, $headers);

            throw $e;
        }
    }

    /**
     * @requires OSFAMILY Linux
     *
     * @dataProvider configDataProvider
     */
    public function testLinuxBinaryCompatibility(Version $version): void
    {
        if (!Locator::exists('libSDL2_image-2.0.so.0')) {
            $this->markTestSkipped('sdl2_image not installed');
        }

        $headers = (string)SDL2Image::create($version);

        try {
            \FFI::cdef($headers, Locator::resolve('libSDL2_image-2.0.so.0'));
        } catch (\FFI\ParserException $e) {
            $this->dumpExceptionInfo($e, $headers);

            throw $e;
        }
    }
}
