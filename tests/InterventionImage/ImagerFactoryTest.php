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

namespace Tobento\Service\Imager\Test\InterventionImage;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ImagerFactoryInterface;
use Tobento\Service\Imager\ImagerInterface;

/**
 * ImagerFactoryTest
 */
class ImagerFactoryTest extends TestCase
{
    public function testThatImplementsImagerFactoryInterface()
    {
        $imagerFactory = new ImagerFactory(config: ['driver' => 'gd']);
        
        $this->assertInstanceof(
            ImagerFactoryInterface::class,
            $imagerFactory
        );
    }
    
    public function testCreateImagerMethod()
    {
        $imagerFactory = new ImagerFactory();
        
        $this->assertInstanceof(
            ImagerInterface::class,
            $imagerFactory->createImager()
        );
    }
}