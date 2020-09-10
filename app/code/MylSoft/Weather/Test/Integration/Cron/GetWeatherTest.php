<?php

namespace MylSoft\Weather\Test\Integration\Cron;

use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Cron\GetWeather;
use Magento\Framework\HTTP\Client\Curl;
use Magento\TestFramework\Helper\Bootstrap;

class GetWeatherTest extends TestCase
{
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
    }

    public function testGetCityData()
    {
        $curlMock = $this->getMockBuilder(Curl::class)
            ->disableOriginalConstructor()
            ->setMethods(['getBody'])
            ->getMock();

        $curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([
                'name' => 'test',
                'id' => 1,
                'cod' => 200
            ]));

        $object = new GetWeather($this->objectManager, $curlMock);
        $response = $object->getCityData('Test', 'ts');

        $this->assertEquals('test', $response['name']);
        $this->assertEquals('1', $response['city_id']);
    }

    public function testGetCityData404()
    {
        $curlMock = $this->getMockBuilder(Curl::class)
            ->disableOriginalConstructor()
            ->setMethods(['getBody'])
            ->getMock();

        $curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([
                'name' => 'test',
                'id' => 1,
                'cod' => 404
            ]));

        $object = new GetWeather($this->objectManager, $curlMock);
        $response = $object->getCityData('Test', 'ts');

        $this->assertEquals([], $response);
    }
}
