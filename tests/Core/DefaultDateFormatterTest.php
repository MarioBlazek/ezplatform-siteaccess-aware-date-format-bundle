<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Tests\Core;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverterInterface;
use IntlDateFormatter;
use Marek\SiteAccessAwareDateFormatBundle\Core\DefaultDateFormatter;
use PHPUnit\Framework\TestCase;

class DefaultDateFormatterTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $localeConverter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configResolver;

    /**
     * @var array
     */
    protected $languages;

    /**
     * @var \Marek\SiteAccessAwareDateFormatBundle\Core\DefaultDateFormatter
     */
    protected $formatter;

    public function setUp()
    {
        $this->localeConverter = $this->getMockBuilder(LocaleConverterInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['convertToPOSIX', 'convertToEz'])
            ->getMock();

        $this->configResolver = $this->getMockBuilder(ConfigResolverInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasParameter', 'getParameter', 'setDefaultNamespace', 'getDefaultNamespace'])
            ->getMock();

        $this->languages = [
            'eng-GB',
            'ger-DE',
        ];

        $this->formatter = new DefaultDateFormatter($this->localeConverter, $this->configResolver, $this->languages);
    }

    /**
     * @covers \Marek\SiteAccessAwareDateFormatBundle\Core\DefaultDateFormatter::format()
     */
    public function testWithDefaultOption()
    {
        $date = $this->getDate();

        $formatter = new IntlDateFormatter('en_EN', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);

        $this->configResolver->expects($this->once())
            ->method('hasParameter')
            ->willReturn(false);

        $this->localeConverter->expects($this->once())
            ->method('convertToPOSIX')
            ->with('eng-GB')
            ->willReturn('en_EN');

        $this->assertEquals(
            $formatter->format($date),
            $this->formatter->format($date, 'default')
        );
    }

    protected function getDate()
    {
        $date = new \DateTime();
        $date->setDate(1989, 10, 24);

        return $date;
    }
}
