<?php
namespace Magentomaster\Testmodule\Block\Adminhtml\Contact\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magentomaster\Testmodule\Block\Adminhtml\Contact\Edit\Buttons\Generic;

class Reset extends Generic implements ButtonProviderInterface
{
    /**
     * get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
