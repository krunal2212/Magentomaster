<?php

namespace Magentomaster\Testmodule\Controller\Index;

use Magento\Catalog\Model\ProductFactory;

class Saveform extends \Magento\Framework\App\Action\Action
{
    protected $_contact;
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magentomaster\Testmodule\Model\Contact   $contact)
    {
        $this->_contact = $contact;
        parent::__construct($context);
    }

    public function execute()
    {

        if ($name = $this->getRequest()->getParam('name')) {
            $contactForm = $this->_contact->setData($this->getRequest()->getParams());
            $contactForm->save();
            $this->messageManager->addSuccessMessage("Thank you, We got your information, We will contact you soon.");
        }
    }
}
