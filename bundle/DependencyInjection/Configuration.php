<?php

namespace Marek\SiteAccessAwareDateFormatBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration extends SiteAccessConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('marek_site_access_aware_date_format');

        $nodeBuilder = $this->generateScopeBaseNode($rootNode);


        $nodeBuilder
            ->arrayNode('formats')
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('format')
                    ->scalarPrototype()
                    ->end()
            ->end();

        $nodeBuilder->end();

        return $treeBuilder;
    }
}
