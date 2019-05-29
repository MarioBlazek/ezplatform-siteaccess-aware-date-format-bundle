<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Twig\Extension;

use DateTimeInterface;
use Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Environment;
use Twig\Extension\CoreExtension;

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
            new TwigFilter('m_datetime', [$this, 'format'], ['needs_environment' => true]),
        ];
    }

    /**
     * Calls date formatter.
     *
     * @param \Twig\Environment $environment
     * @param \DateTimeInterface $date
     * @param string $format
     * @param string|null $timezone
     *
     * @return string
     */
    public function format(Environment $environment, DateTimeInterface $date, $format = 'default', $timezone = null): string
    {
        if (null === $timezone) {
            $timezone = $environment->getExtension(CoreExtension::class)->getTimezone();
        } elseif (!$timezone instanceof \DateTimeZone) {
            $timezone = new \DateTimeZone($timezone);
        }

        $date = clone $date;
        if (false !== $timezone) {
            $date->setTimezone($timezone);
        }

        return $this->formatter->format($date, $format);
    }
}
