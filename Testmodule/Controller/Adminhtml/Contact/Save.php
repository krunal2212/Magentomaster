<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterfaceFactory;
use Magentomaster\Testmodule\Controller\Adminhtml\Contact as ContactController;
use Magentomaster\Testmodule\Model\UploaderPool;

class Save extends ContactController
{
    /**
     * Contact factory
     *
     * @var ContactInterfaceFactory
     */
    protected $contactFactory;

    /**
     * Data Object Processor
     *
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Uploader pool
     *
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Data Persistor
     *
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ContactRepositoryInterface $contactRepository
     * @param PageFactory $resultPageFactory
     * @param ContactInterfaceFactory $contactFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ContactRepositoryInterface $contactRepository,
        PageFactory $resultPageFactory,
        ContactInterfaceFactory $contactFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool,
        DataPersistorInterface $dataPersistor
    ) {
        $this->contactFactory      = $contactFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->uploaderPool        = $uploaderPool;
        $this->dataPersistor       = $dataPersistor;
        parent::__construct($context, $coreRegistry, $contactRepository, $resultPageFactory);
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magentomaster\Testmodule\Api\Data\ContactInterface $contact */
        $contact = null;
        $postData = $this->getRequest()->getPostValue();
        $data = $postData;
        $id = !empty($data['contact_id']) ? $data['contact_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $contact = $this->contactRepository->getById((int)$id);
            } else {
                unset($data['contact_id']);
                $contact = $this->contactFactory->create();
            }
            $this->dataObjectHelper->populateWithArray($contact, $data, ContactInterface::class);
            $this->contactRepository->save($contact);
            $this->messageManager->addSuccessMessage(__('You saved the Contact'));
            $this->dataPersistor->clear('magentomaster_testmodule_contact');
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('magentomaster_testmodule/contact/edit', ['contact_id' => $contact->getId()]);
            } else {
                $resultRedirect->setPath('magentomaster_testmodule/contact');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('magentomaster_testmodule_contact', $postData);
            $resultRedirect->setPath('magentomaster_testmodule/contact/edit', ['contact_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Contact'));
            $this->dataPersistor->set('magentomaster_testmodule_contact', $postData);
            $resultRedirect->setPath('magentomaster_testmodule/contact/edit', ['contact_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param string $type
     * @return \Magentomaster\Testmodule\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
