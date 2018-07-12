<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 10/07/18
 * Time: 10:23
 */

namespace ElKuKu\G11nBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ElKuKuG11nExtension extends Extension
{
    public function getAlias()
    {
        return 'elkuku_g11n';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        (new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        ))->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);

        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('elkuku_g11n_loader');
        $definition->setArgument(1, $config['defaultLang']);
        $definition->setArgument(2, $config['debug']);
    }
}
