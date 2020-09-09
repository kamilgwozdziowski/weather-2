<?php

namespace MylSoft\Weather\Test\Block;

use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Block\CityWeather;

class CityWeatherTest extends TestCase
{
    /** @var CityWeather */
    private $object;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $contectMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->object = new CityWeather($contectMock);
    }

    public function testIndexInstance()
    {
        $this->assertInstanceOf(CityWeather::class, $this->object);
    }
}
