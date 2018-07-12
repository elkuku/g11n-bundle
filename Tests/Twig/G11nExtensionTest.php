<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 11/07/18
 * Time: 17:59
 */

namespace ElKuKu\G11nBundle\Tests\Twig;

use ElKuKu\G11nBundle\Twig\G11nExtension;
use PHPUnit\Framework\TestCase;

class G11nExtensionTest extends TestCase
{
    public function testThis()
    {
        $extension = new G11nExtension('.');

        $this->assertNotEmpty($extension->getCurrentLang());
    }
}
