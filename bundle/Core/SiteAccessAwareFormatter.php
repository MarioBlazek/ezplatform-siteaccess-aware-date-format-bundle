<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Core;

use DateTimeInterface;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Marek\SiteAccessAwareDateFormatBundle\API\DateFormatter;
use Marek\SiteAccessAwareDateFormatBundle\DependencyInjection\Configuration;
use RuntimeException;

final class SiteAccessAwareFormatter
{
    /**
     * @var \Marek\SiteAccessAwareDateFormatBundle\API\DateFormatter
     */
    private $defaultDateFormatter;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * SiteAccessAwareFormatter constructor.
     *
     * @param \Marek\SiteAccessAwareDateFormatBundle\API\DateFormatter $defaultDateFormatter
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     */
    public function __construct(DateFormatter $defaultDateFormatter, ConfigResolverInterface $configResolver)
    {
        $this->defaultDateFormatter = $defaultDateFormatter;
        $this->configResolver = $configResolver;
    }

    /**
     * @inheritdoc
     */
    public function format(DateTimeInterface $date, string $dateFormatIdentifier): string
    {
        if ($dateFormatIdentifier === DateFormatter::FORMAT_DEFAULT) {
            return $this->defaultDateFormatter->format($date, $dateFormatIdentifier);
        }

        if (!$this->configResolver->hasParameter('formats', Configuration::TREE_ROOT)) {
            throw new RuntimeException(
                sprintf('Configuration %s is missing formats option.', Configuration::TREE_ROOT)
            );
        }

        $formats = $this->configResolver->getParameter('formats', Configuration::TREE_ROOT);

        if (!array_key_exists($dateFormatIdentifier, $formats)) {
            throw new RuntimeException(
                sprintf('Given datetime format %s does not exist in configuration.', $dateFormatIdentifier)
            );
        }

        return $date->format(
            $formats[$dateFormatIdentifier]
        );
    }
}
