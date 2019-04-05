<?php

namespace Marek\SiteAccessAwareDateFormatBundle\Twig\Extension;

use Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class DateTimeFormatterExtension extends AbstractExtension
{
    /**
     * @var \Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter
     */
    protected $formatter;

    public function __construct(SiteAccessAwareFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('datetime', [$this, 'format']),
        ];
    }

    public function format($presentFormat, $format = '')
    {
        return $this->formatter->format($presentFormat, $format);
    }
}
