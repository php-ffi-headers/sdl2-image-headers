<?php

/**
 * This file is part of FFI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FFI\Headers\SDL2Image\Tests;

use FFI\Headers\SDL2Image\Version;
use FFI\Headers\SDL2Image;

final class ContentRenderingTestCase extends TestCase
{
    /**
     * @testdox Testing that the headers are successfully built
     *
     * @dataProvider configDataProvider
     */
    public function testRenderable(Version $version): void
    {
        $this->expectNotToPerformAssertions();

        (string)SDL2Image::create($version);
    }
}
