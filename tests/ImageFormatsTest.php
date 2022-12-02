<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Imager\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\ImageFormats;
use Tobento\Service\Filesystem\FileFormatsInterface;

/**
 * ImageFormatsTest
 */
class ImageFormatsTest extends TestCase
{
    public function testThatImplementsFileFormatsInterface()
    {
        $this->assertInstanceof(
            FileFormatsInterface::class,
            new ImageFormats()
        );
    }
}