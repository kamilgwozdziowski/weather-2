<?php

namespace MylSoft\Weather\Test\Unit\Cron;

use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Cron\GetWeather;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\HTTP\Client\Curl;

class GetWeatherTest extends TestCase
{
    /** @var GetWeather */
    private $object;

    /** @var ObjectManager */
    private $objectManager;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);
        $this->object = $this->objectManager->getObject(GetWeather::class);
    }

    public function testGetWeatherInstance()
    {
        $this->assertInstanceOf(GetWeather::class, $this->object);
    }

    public function testGetCityData()
    {
        $city = 'Testowe';
        $code = 'ts';
        $urlCorect = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . ',' . $code . '&units=metric&appid=3f343b0ca451c3d06e48b7220b0c7c4d';

        $url = $this->object->getUrl($city, $code);
        $this->assertEquals($urlCorect, $url);
    }

    public function  testParseWeatherData()
    {
        $json = json_encode([
            'id' => 1,
            'name' => 'test',
            'cod' => 200,
            'sys' => [
                'country' => 'Test'
            ],
            'main' => [
                'temp_max' => 20,
                'temp_min' => 0,
                'feels_like' => 20,
                'temp' => 20,
                'pressure' => 30,
                'humidity' => 100
            ],
            'wind' => [
                'deg' => 30,
                'speed' => 20
            ],
            'clouds' => [
                'all' => 100
            ]
        ]);

        $responseData = $this->object->parseWeatherData($json);
        $this->assertEquals(1, $responseData['city_id']);
        $this->assertEquals('test', $responseData['name']);
    }

    public function testParseWeatherData404()
    {
        $json = json_encode([
            'cod' => 404
        ]);

        $responseData = $this->object->parseWeatherData($json);
        $this->assertCount(0, $responseData);
    }
}
