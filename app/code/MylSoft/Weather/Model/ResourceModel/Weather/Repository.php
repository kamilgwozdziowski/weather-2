<?php

namespace MylSoft\Weather\Model\ResourceModel\Weather;

use MylSoft\Weather\Model\ResourceModel\Weather;

class Repository
{
    private $resourceModel;

    public function __construct(Weather $resource)
    {
        $this->resourceModel = $resource;
    }
}
