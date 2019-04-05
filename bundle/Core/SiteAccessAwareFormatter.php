<?php

namespace Marek\SiteAccessAwareDateFormatBundle\Core;

use eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverterInterface;
use IntlDateFormatter;
use DateTime;
use RuntimeException;

class SiteAccessAwareFormatter
{
    const FORMAT_DEFAULT = 'default';

    /**
     * @var LocaleConverterInterface
     */
    protected $localeConverter;

    /**
     * @var array
     */
    protected $formats;

    /**
     * @var array
     */
    protected $languages;

    public function __construct(LocaleConverterInterface $localeConverter, array $formats, array $languages)
    {
        $this->localeConverter = $localeConverter;
        $this->formats = $formats;
        dump($formats);
        dump($languages);
        $this->languages = $languages;
    }

    public function format(DateTime $date, $dateFormatIdentifier)
    {
        if ($dateFormatIdentifier === self::FORMAT_DEFAULT) {

            $formatter = new IntlDateFormatter(
                $this->localeConverter->convertToPOSIX($this->languages[0]),
                IntlDateFormatter::SHORT,
                IntlDateFormatter::SHORT
            );

            return $formatter->format($date);

        }

        if (in_array($dateFormatIdentifier, $this->formats)) {
            throw new RuntimeException(
                sprintf("Given datetime format %s does not exist in configuration.", $dateFormatIdentifier)
            );
        }

        return $date->format(
            $this->formats[$dateFormatIdentifier]
        );
    }
}
