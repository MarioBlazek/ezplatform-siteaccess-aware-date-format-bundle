<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration extends SiteAccessConfiguration
{
    /**
     * @var string
     */
    public const TREE_ROOT = 'marek_site_access_aware_date_format';

    /**
     * @var array
     */
    protected $validFormats = ['none', 'full', 'short', 'long', 'medium'];

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::TREE_ROOT);

        $nodeBuilder = $this->generateScopeBaseNode($rootNode);

        $nodeBuilder
            ->arrayNode('defaults')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('format')
                        ->defaultValue('short')
                        ->cannotBeEmpty()
                        ->validate()
                            ->ifNotInArray($this->validFormats)
                            ->thenInvalid('Invalid default date format value provided.')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('formats')
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('format')
                    ->prototype('scalar')
                    ->end()
            ->end();

        $nodeBuilder->end();

        return $treeBuilder;
    }
}
