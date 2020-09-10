<?php

namespace MylSoft\Weather\Cron;

use Magento\Framework\HTTP\Client\Curl;
use \Magento\Framework\ObjectManagerInterface;

class GetWeather
{

    protected $_objectManager;
    private $_curlClient;
    private $_apiUrl;

    /**
     * Constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param Curl $curlClient
     */
    public function __construct(ObjectManagerInterface $objectManager, Curl $curlClient)
    {
        $this->_objectManager = $objectManager;
        $this->_curlClient = $curlClient;
        $this->_apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q={city},{code}&units=metric&appid=3f343b0ca451c3d06e48b7220b0c7c4d';
    }

    /**
     * Get API URL
     *
     * @param string $city
     * @param string $code
     * @return string
     */
    public function getUrl(string $city, string $code): string
    {
        return str_replace(['{city}', '{code}'], [$city, $code], $this->_apiUrl);
    }

    /**
     * Get data from API
     *
     * @param string $city
     * @param string $countryCode
     * @return array
     */
    public function getCityData(string $city, string $countryCode): array
    {
        $url = $this->getUrl($city, $countryCode);
        $this->_curlClient->get($url);
        $response = $this->_curlClient->getBody();

        return $this->parseWeatherData($response);
    }

    public function parseWeatherData(string $jsonResponse): array
    {
        $jsonObj = json_decode($jsonResponse);

        if ($jsonObj->cod != 200) {
            return [];
        }

        return [
            'city_id' => $jsonObj->id ?? null,
            'name' => $jsonObj->name,
            'country' => $jsonObj->sys->country ?? null,
            'temp' => $jsonObj->main->temp ?? null,
            'feels_like' => $jsonObj->main->feels_like ?? null,
            'temp_min' => $jsonObj->main->temp_min ?? null,
            'temp_max' => $jsonObj->main->temp_max ?? null,
            'wind_speed' => $jsonObj->wind->speed ?? null,
            'wind_deg' => $jsonObj->wind->deg ?? null,
            'pressure' => $jsonObj->main->pressure ?? null,
            'humidity' => $jsonObj->main->humidity ?? null,
            'clouds' => $jsonObj->clouds->all ?? null,
        ];
    }

    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info(__METHOD__);

        $repo = $this->_objectManager->get('MylSoft\Weather\Model\ResourceModel\WeatherRepository');
        $logger->info('TEST MYL2 weathe:');
        $response = $this->getCityData('Lublin', 'pl');
        $res = $repo->addData($response);
        $logger->info($res);

        return $this;
    }
}
