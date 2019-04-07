<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Core;

use DateTimeInterface;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverterInterface;
use IntlDateFormatter;
use Marek\SiteAccessAwareDateFormatBundle\API\DateFormatter;
use Marek\SiteAccessAwareDateFormatBundle\DependencyInjection\Configuration;

final class DefaultDateFormatter implements DateFormatter
{
    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverterInterface
     */
    private $localeConverter;

    /**
     * @var array
     */
    private $languages;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * DefaultDateFormatter constructor.
     *
     * @param \eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverterInterface $localeConverter
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     * @param array $languages
     */
    public function __construct(LocaleConverterInterface $localeConverter, ConfigResolverInterface $configResolver, array $languages)
    {
        $this->localeConverter = $localeConverter;
        $this->languages = $languages;
        $this->configResolver = $configResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function format(DateTimeInterface $date, string $dateFormatIdentifier): string
    {
        $defaultFormat = 'short';
        if ($this->configResolver->hasParameter('defaults', Configuration::TREE_ROOT)) {
            $defaultFormat = $this->configResolver->getParameter('defaults', Configuration::TREE_ROOT);
            $defaultFormat = $defaultFormat['format'];
        }

        switch ($defaultFormat) {
            case 'none':
                $dateConstant = IntlDateFormatter::NONE;

                break;
            case 'full':
                $dateConstant = IntlDateFormatter::FULL;

                break;
            case 'long':
                $dateConstant = IntlDateFormatter::LONG;

                break;
            case 'medium':
                $dateConstant = IntlDateFormatter::MEDIUM;

                break;
            default:
                $dateConstant = IntlDateFormatter::SHORT;

                break;
        }
        $formatter = new IntlDateFormatter(
            $this->localeConverter->convertToPOSIX($this->languages[0]),
            $dateConstant,
            $dateConstant
        );

        return $formatter->format($date);
    }
}
