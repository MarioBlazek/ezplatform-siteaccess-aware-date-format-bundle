<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\API;

use DateTimeInterface;

interface DateFormatter
{
    /**
     * Defines default date format.
     */
    public const FORMAT_DEFAULT = 'default';

    /**
     * Formats given date object by defautl format
     * or one of the formats set in configuration.
     *
     * @param \DateTimeInterface $date
     * @param string $dateFormatIdentifier
     *
     * @return string
     */
    public function format(DateTimeInterface $date, string $dateFormatIdentifier): string;
}
