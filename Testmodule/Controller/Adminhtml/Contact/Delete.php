<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magentomaster\Testmodule\Controller\Adminhtml\Contact as ContactController;

class Delete extends ContactController
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('contact_id');
        if ($id) {
            try {
                $this->contactRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The Contact has been deleted.'));
                $resultRedirect->setPath('magentomaster_testmodule/*/');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The Contact no longer exists.'));
                return $resultRedirect->setPath('magentomaster_testmodule/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('magentomaster_testmodule/contact/edit', ['contact_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the Contact'));
                return $resultRedirect->setPath('magentomaster_testmodule/contact/edit', ['contact_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Contact to delete.'));
        $resultRedirect->setPath('magentomaster_testmodule/*/');
        return $resultRedirect;
    }
}
