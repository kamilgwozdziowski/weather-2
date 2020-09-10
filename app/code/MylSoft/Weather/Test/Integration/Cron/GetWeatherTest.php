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

    /** @var Curl */
    private $curlMock;

    /** @var GetWeather */
    private $object;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->objectManager = Bootstrap::getObjectManager();
        $this->curlMock = $this->createMock(Curl::class);

        $this->object = new GetWeather($this->objectManager, $this->curlMock);
    }

    /**
     * Test get city data API
     *
     * @return void
     */
    public function testGetCityData()
    {
        $this->curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->getDefaultDataJson());

        $response = $this->object->getCityData('Test', 'ts');

        $this->assertEquals('test', $response['name']);
        $this->assertEquals('1', $response['city_id']);
    }

    /**
     * Test code back from API
     * 
     * @dataProvider dataPrivider404
     */
    public function testGetCityData404(int $code, bool $expect)
    {
        $this->curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn($this->getDefaultDataJson([
                'cod' =>  $code
            ]));

        $response = $this->object->getCityData('Test', 'ts');

        $this->assertEquals($expect, count($response) == 0);
    }

    /**
     * Get default data to test
     *
     * @param array $params
     * @return string
     */
    private function getDefaultDataJson(array $params = []): string
    {
        $arr = [
            'name' => 'test',
            'id' => 1,
            'cod' => 200
        ];

        $arr = array_merge($arr, $params);
        return json_encode($arr);
    }

    /**
     * Data Provider
     *
     * @return void
     */
    public function dataPrivider404()
    {
        return [
            [404, true],
            [500, true],
            [200, false]
        ];
    }
}
