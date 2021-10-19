<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magentomaster\Testmodule\Api\Data\ContactInterface;
use Magentomaster\Testmodule\Controller\Adminhtml\Contact\MassAction;

class MassDelete extends MassAction
{
    /**
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @return $this
     */
    protected function massAction(ContactInterface $contact)
    {
        $this->contactRepository->delete($contact);
        return $this;
    }
}
