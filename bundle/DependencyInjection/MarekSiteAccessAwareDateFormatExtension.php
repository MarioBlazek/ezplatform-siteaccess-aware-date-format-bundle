<?php

namespace Marek\SiteAccessAwareDateFormatBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MarekSiteAccessAwareDateFormatExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $processor = new ConfigurationProcessor($container, 'marek_site_access_aware_date_format');
        $configArrays = ['formats'];

        $scopes = array_merge(array('default'), $container->getParameter('ezpublish.siteaccess.list'));
        foreach ($configArrays as $configArray) {
            $processor->mapConfigArray($configArray, $config);
            foreach ($scopes as $scope) {
                $paramName = 'marek_site_access_aware_date_format' . '.' . $scope . '.' . $configArray;
                if (!$container->hasParameter($paramName)) {
                    continue;
                }
                $scopeConfig = $container->getParameter($paramName);
                foreach ((array) $scopeConfig as $key => $value) {
                    $container->setParameter($paramName . '.' . $key, $value);
                }
            }
        }
    }
}
