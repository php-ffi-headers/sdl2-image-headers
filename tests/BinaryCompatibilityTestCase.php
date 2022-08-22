<?php

/**
 * This file is part of FFI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FFI\Headers\SDL2Image\Tests;

use FFI\Headers\SDL2Image;
use FFI\Headers\SDL2Image\Version;
use FFI\Headers\Testing\Downloader;
use FFI\Location\Locator;

class BinaryCompatibilityTestCase extends TestCase
{
    private const DIR_STORAGE = __DIR__ . '/storage';

    protected function skipIfVersionNotCompatible(Version $version, string $binary): void
    {
        $this->skipIfNoFFISupport();

        $ffi = \FFI::cdef(<<<'CPP'
        typedef struct SDL_version {
            uint8_t major;
            uint8_t minor;
            uint8_t patch;
        } SDL_version;

        extern const SDL_version * IMG_Linked_Version(void);
        CPP, $binary);

        $ver = $ffi->IMG_Linked_Version();
        $actual = \sprintf('%d.%d.%d', $ver->major, $ver->minor, $ver->patch);

        if (\version_compare($version->toString(), $actual, '>')) {
            $message = 'Unable to check compatibility because the installed version of the '
                . 'library (v%s) is lower than the tested headers (v%s)';

            $this->markTestSkipped(\sprintf($message, $actual, $version->toString()));
        }
    }

    /**
     * @requires OSFAMILY Windows
     *
     * @dataProvider configDataProvider
     */
    public function testWindowsBinaryCompatibility(Version $version): void
    {
        if (!\is_file(self::DIR_STORAGE . '/SDL2.dll')) {
            Downloader::zip(\vsprintf('https://www.libsdl.org/release/SDL2-2.24.0-win32-x64.zip', [
                $version->toString()
            ]))
                ->extract('SDL2.dll', self::DIR_STORAGE . '/SDL2.dll');
        }

        if (!\is_file(self::DIR_STORAGE . '/SDL2_image.dll')) {
            Downloader::zip('https://www.libsdl.org/projects/SDL_image/release/SDL2_image-2.6.2-win32-x64.zip')
                ->extract('SDL2_image.dll', self::DIR_STORAGE . '/SDL2_image.dll');
        }

        $binary = self::DIR_STORAGE . '/SDL2_image.dll';

        // Set LoadLibrary linker directory
        \chdir(\dirname($binary));

        $this->skipIfVersionNotCompatible($version, $binary);
        $this->assertHeadersCompatibleWith(SDL2Image::create($version), $binary);
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

        $binary = Locator::resolve('libSDL2_image-2.0.0.dylib');
        $this->skipIfVersionNotCompatible($version, $binary);
        $this->assertHeadersCompatibleWith(SDL2Image::create($version), $binary);
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

        $binary = Locator::resolve('libSDL2_image-2.0.so.0');
        $this->skipIfVersionNotCompatible($version, $binary);
        $this->assertHeadersCompatibleWith(SDL2Image::create($version), $binary);
    }
}
