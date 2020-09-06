<?php

namespace MylSoft\Weather\Test\Block\Widget;

use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Block\Widget\Index;

class IndexTest extends TestCase
{
    /** @var Index */
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
        $this->object = new Index($contectMock);
    }

    public function testIndexInstance()
    {
        $this->assertInstanceOf(Index::class, $this->object);
    }

    public function testIndexInterfaceImplements()
    {
        $this->assertInstanceOf(BlockInterface::class, $this->object);
    }
}
