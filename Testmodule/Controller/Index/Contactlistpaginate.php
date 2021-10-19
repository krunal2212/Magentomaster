<?php

namespace Magentomaster\Testmodule\Controller\Index;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;

class Contactlistpaginate extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $_storeManager;
    protected $contact;
    protected $contactCollection;

    public function __construct(
        \Magento\Framework\App\Action\Context                               $context,
        \Magento\Framework\Data\Form\FormKey                                $formKey,
        ProductFactory                                                      $productFactory,
        StoreManager                                                        $storeManager,
        \Magentomaster\Testmodule\Model\Contact                                 $contact,
        \Magentomaster\Testmodule\Model\ResourceModel\Contact\CollectionFactory $contactCollection
    )
    {
        $this->productFactory = $productFactory;
        $this->contact = $contact;
        $this->_storeManager = $storeManager;
        $this->contactCollection = $contactCollection;
        parent::__construct($context);
    }


    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $page = ($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : 1;
            $pageSize = 100;
            $newsCollection = $this->contactCollection->create();
            $newsCollection->setOrder('contact_id', 'DESC');
            $newsCollection->setPageSize($pageSize);
            $newsCollection->setCurPage($page);

            $totalCount = $newsCollection->getSize();
            if ($totalCount > 0) {
                echo json_encode($newsCollection->getData());
                exit;
            }
            echo json_encode([]);
            exit;


        }
    }
}





