<?php

namespace Magentomaster\Testmodule\Test\Unit\Model;

class Unittest extends \PHPUnit\Framework\TestCase
{
    public function setUp() : void
    {
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->_calculator = $this->_objectManager->getObject("Magentomaster\Testmodule\Model\Unittest");
    }

    public function testcaseAddition(): void
    {
        $this->_actulResult = $this->_calculator->additiondata();
        $this->_desiredResult = json_encode([]);
        $this->assertEquals($this->_desiredResult, $this->_actulResult);
    }
}
