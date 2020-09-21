<?php

namespace MylSoft\Weather\Test\Integration\Block;

use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Block\CityWeather;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * @magentoAppArea frontend
 */
class CityWeatherTest extends TestCase
{
    /** @var CityWeather */
    private $object;

    /** @var LayoutInterface */
    private $layout;

    /** @var ObjectManagerInterface */
    private $objectManager;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->objectManager = Bootstrap::getObjectManager();
        $this->object = $this->objectManager->get(CityWeather::class);
        $this->layout = $this->objectManager->get(LayoutInterface::class);
    }

    public function testToHtml()
    {
        $template = 'MylSoft_Weather::city_weather.phtml';
        $temperature = 24;

        $block = $this->layout->createBlock(CityWeather::class);
        $block->setTemplate($template);
        $block->setData('temperature', $temperature);
        $html = $block->toHtml();

        $this->assertContains('<b>' . $temperature . '</b>', $html);
        $this->assertTrue(true);
    }
}
