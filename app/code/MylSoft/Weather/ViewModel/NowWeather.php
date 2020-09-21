<?php
namespace MylSoft\Weather\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use MylSoft\Weather\Model\ResourceModel\Weather\Repository;

class NowWeather implements ArgumentInterface
{
    /**
     * Weather repository
     *
     * @var Repository
     */
    private $_weatherRepository;

    /**
     * Constructor
     *
     * @param Repository $weatherRepository
     */
    public function __construct(Repository $weatherRepository)
    {
        $this->_weatherRepository = $weatherRepository;
    }

    /**
     * Return last row from DB
     *
     * @return array
     */
    public function getWeather(): array
    {
        return $this->_weatherRepository->getLast();
    }
}