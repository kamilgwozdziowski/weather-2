<?php

namespace MylSoft\Weather\Test\Integration\Block\Widget;

use PHPUnit\Framework\TestCase;
use MylSoft\Weather\Block\Widget\Index;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * @magentoAppArea frontend
 */
class IndexTest extends TestCase
{
    /** @var Index */
    private $object;

    /** @var LayoutInterface */
    private $layout;

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
        $this->object = $this->objectManager->get(Index::class);
        $this->layout = $this->objectManager->get(LayoutInterface::class);
    }

    public function testToHtml()
    {
        $template = 'MylSoft_Weather::widget/index.phtml';
        $title = 'Test Title';
        $temperature = 24;

        $block = $this->layout->createBlock(Index::class);
        $block->setTemplate($template);
        $block->setData('title', $title);
        $block->setData('temperature', $temperature);
        $html = $block->toHtml();

        $this->assertContains($title, $html);
        $this->assertContains('<b>' . $temperature . '</b>', $html);
        $this->assertTrue(true);
    }
}
