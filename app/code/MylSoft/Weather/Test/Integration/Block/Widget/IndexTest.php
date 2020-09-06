<?php

namespace MylSoft\Weather\Test\Integration\Block\Widget;

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
        $objectMenager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->object = $objectMenager->create(Index::class);
    }

    public function testToHtml()
    {
        $template = 'MylSoft_Weather::widget/index.phtml';
        $title = 'Test Title';

        $this->object->setTemplate($template);
        $this->object->setData('title', $title);

        $html = $this->object->toHtml();
        var_dump($html);

        //$this->assertContains($title, $html);
        $this->assertTrue(false);
    }
}
