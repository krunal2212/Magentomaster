<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magentomaster\Testmodule\Controller\Adminhtml\Contact as ContactController;
use Magentomaster\Testmodule\Controller\RegistryConstants;

class Edit extends ContactController
{
    /**
     * Initialize current Contact and set it in the registry.
     *
     * @return int
     */
    protected function initContact()
    {
        $contactId = $this->getRequest()->getParam('contact_id');
        $this->coreRegistry->register(RegistryConstants::CURRENT_CONTACT_ID, $contactId);

        return $contactId;
    }

    /**
     * Edit or create Contact
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $contactId = $this->initContact();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magentomaster_Testmodule::testmodule_contact');
        $resultPage->getConfig()->getTitle()->prepend(__('Form'));
        $resultPage->addBreadcrumb(__('Magentomaster'), __('Magentomaster'));
        $resultPage->addBreadcrumb(__('Form'), __('Form'), $this->getUrl('magentomaster_testmodule/contact'));

        if ($contactId === null) {
            $resultPage->addBreadcrumb(__('New'), __('New'));
            $resultPage->getConfig()->getTitle()->prepend(__('New'));
        } else {
            $resultPage->addBreadcrumb(__('Edit'), __('Edit'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->contactRepository->getById($contactId)->getName()
            );
        }
        return $resultPage;
    }
}
