<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magentomaster\Testmodule\Controller\Adminhtml\Contact as ContactController;

class Index extends ContactController
{
    /**
     * Form list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magentomaster_Testmodule::contact');
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Form'));
        $resultPage->addBreadcrumb(__('Magentomaster'), __('Magentomaster'));
        $resultPage->addBreadcrumb(__('Contact Form'), __('Contact Form'));
        return $resultPage;
    }
}
