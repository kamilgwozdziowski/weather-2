<?php

namespace MylSoft\Weather\Model\ResourceModel\Weather;

use MylSoft\Weather\Model\ResourceModel\Weather;
use MylSoft\Weather\Model\WeatherFactory;

class Repository
{
    private $_resourceModel;
    private $_weatherFactory;

    public function __construct(Weather $resource, WeatherFactory  $weatherFactory)
    {
        $this->_resourceModel = $resource;
        $this->_weatherFactory = $weatherFactory;
    }

    /**
     * Save new weather row
     *
     * @param array $model
     * @return void
     */
    public function save(array $params)
    {
        $data['time'] = time();
        $weather = $this->_weatherFactory->create();
        $weather->setData($params);
        $weather->save();

        return $weather;
    }

    public function getLast(): array
    {
        $connection = $this->_resourceModel->getConnection();
        $select = $connection->select()->from(['mylsoft_weather_weather'])->order('id', )->limit(1);
        return $connection->fetchRow($select);
    }
}
