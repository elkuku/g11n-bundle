<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 09/07/18
 * Time: 19:37
 */

namespace ElKuKu\G11nBundle;

use ElKuKu\G11nBundle\DependencyInjection\ElKuKuG11nExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElKuKuG11nBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ElKuKuG11nExtension;
        }

        return $this->extension;
    }
}
