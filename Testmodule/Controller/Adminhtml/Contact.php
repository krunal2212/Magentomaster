<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;

abstract class Contact extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Contact repository
     *
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * Page factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ContactRepositoryInterface $contactRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ContactRepositoryInterface $contactRepository,
        PageFactory $resultPageFactory
    ) {
        $this->coreRegistry      = $coreRegistry;
        $this->contactRepository = $contactRepository;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
}
