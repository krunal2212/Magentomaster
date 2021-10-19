<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterface;
use Magentomaster\Testmodule\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;

abstract class MassAction extends Action
{
    /**
     * Contact repository
     *
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * Mass Action filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Contact collection factory
     *
     * @var ContactCollectionFactory
     */
    protected $collectionFactory;

    /**
     * Action success message
     *
     * @var string
     */
    protected $successMessage;

    /**
     * Action error message
     *
     * @var string
     */
    protected $errorMessage;

    /**
     * constructor
     *
     * @param Context $context
     * @param ContactRepositoryInterface $contactRepository
     * @param Filter $filter
     * @param ContactCollectionFactory $collectionFactory
     * @param string $successMessage
     * @param string $errorMessage
     */
    public function __construct(
        Context $context,
        ContactRepositoryInterface $contactRepository,
        Filter $filter,
        ContactCollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        $this->contactRepository = $contactRepository;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->successMessage    = $successMessage;
        $this->errorMessage      = $errorMessage;
        parent::__construct($context);
    }

    /**
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @return mixed
     */
    abstract protected function massAction(ContactInterface $contact);

    /**
     * execute action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $contact) {
                $this->massAction($contact);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, $this->errorMessage);
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('magentomaster_testmodule/*/index');
        return $redirectResult;
    }
}
