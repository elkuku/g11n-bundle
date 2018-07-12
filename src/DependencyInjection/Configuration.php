<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 11/07/18
 * Time: 14:33
 */

namespace ElKuKu\G11nBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elkuku_g11n_loader');

        $rootNode
            ->children()
            ->booleanNode('debug')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
