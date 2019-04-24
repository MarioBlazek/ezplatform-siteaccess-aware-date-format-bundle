<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Twig\Extension;

use DateTimeInterface;
use Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class DateTimeFormatterExtension extends AbstractExtension
{
    /**
     * @var \Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter
     */
    protected $formatter;

    /**
     * DateTimeFormatterExtension constructor.
     *
     * @param \Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter $formatter
     */
    public function __construct(SiteAccessAwareFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('m_datetime', [$this, 'format']),
        ];
    }

    /**
     * Calls date formatter.
     *
     * @param \DateTimeInterface $date
     * @param string $format
     *
     * @return string
     */
    public function format(DateTimeInterface $date, $format = 'default'): string
    {
        return $this->formatter->format($date, $format);
    }
}
