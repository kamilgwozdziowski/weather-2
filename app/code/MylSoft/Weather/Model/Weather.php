<?php

namespace MylSoft\Weather\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Weather extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mylsoft_weather_weather';

    protected $_cacheTag = 'mylsoft_weather_weather';

    protected $_eventPrefix = 'mylsoft_weather_weather';

    protected function _construct()
    {
        $this->_init('MylSoft\Weather\Model\ResourceModel\Weather');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
