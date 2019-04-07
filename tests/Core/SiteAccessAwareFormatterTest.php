<?php

declare(strict_types=1);

namespace Marek\SiteAccessAwareDateFormatBundle\Tests\Core;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Marek\SiteAccessAwareDateFormatBundle\API\DateFormatter;
use Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter;
use PHPUnit\Framework\TestCase;

class SiteAccessAwareFormatterTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $defaultFormatter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configResolver;

    /**
     * @var \Marek\SiteAccessAwareDateFormatBundle\Core\SiteAccessAwareFormatter
     */
    protected $siteAccessAwareFormatter;

    public function setUp()
    {
        $this->defaultFormatter = $this->getMockBuilder(DateFormatter::class)
            ->disableOriginalConstructor()
            ->setMethods(['format'])
            ->getMock();

        $this->configResolver = $this->getMockBuilder(ConfigResolverInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasParameter', 'getParameter', 'setDefaultNamespace', 'getDefaultNamespace'])
            ->getMock();

        $this->siteAccessAwareFormatter = new SiteAccessAwareFormatter($this->defaultFormatter, $this->configResolver);
    }

    public function testCustomFormatOption()
    {
        $date = $this->getDate();
        $formats = [];
        $formats['my_custom_format'] = 'Y m d';

        $this->configResolver->expects($this->once())
            ->method('hasParameter')
            ->willReturn(true);

        $this->configResolver->expects($this->once())
            ->method('getParameter')
            ->willReturn($formats);

        $this->assertEquals(
            $date->format($formats['my_custom_format']),
            $this->siteAccessAwareFormatter->format($date, 'my_custom_format')
        );
    }

    public function testShouldThrowExceptionWhenFormatDoesNotExist()
    {
        $date = $this->getDate();
        $formats = [];
        $formats['my_custom_format_2'] = 'Y m d';

        $this->configResolver->expects($this->once())
            ->method('hasParameter')
            ->willReturn(true);

        $this->configResolver->expects($this->once())
            ->method('getParameter')
            ->willReturn($formats);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Given datetime format my_custom_format does not exist in configuration.');

        $this->siteAccessAwareFormatter->format($date, 'my_custom_format');
    }

    public function testShouldThrowExceptionWhenFormatsAreNotAvailable()
    {
        $date = $this->getDate();

        $this->configResolver->expects($this->once())
            ->method('hasParameter')
            ->willReturn(false);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Configuration marek_site_access_aware_date_format is missing formats option.');

        $this->siteAccessAwareFormatter->format($date, 'my_custom_format');
    }

    public function testShouldCallDefaultFormatterInCaseWhenDefaultOptionsIsPassed()
    {
        $date = $this->getDate();

        $this->defaultFormatter->expects($this->once())
            ->method('format')
            ->with($date, 'default');

        $this->configResolver->expects($this->never())
            ->method('hasParameter');

        $this->siteAccessAwareFormatter->format($date, 'default');
    }

    protected function getDate()
    {
        $date = new \DateTime();
        $date->setDate(1989, 10, 24);

        return $date;
    }
}
