<?php
namespace Magentomaster\Testmodule\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterface;
use Magentomaster\Testmodule\Controller\Adminhtml\Contact as ContactController;
use Magentomaster\Testmodule\Model\ResourceModel\Contact as ContactResourceModel;

class InlineEdit extends ContactController
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
     * Data object processor
     *
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data object helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * JSON Factory
     *
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * Contact resource model
     *
     * @var ContactResourceModel
     */
    protected $contactResourceModel;

    /**
     * constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ContactRepositoryInterface $contactRepository
     * @param PageFactory $resultPageFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param JsonFactory $jsonFactory
     * @param ContactResourceModel $contactResourceModel
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ContactRepositoryInterface $contactRepository,
        PageFactory $resultPageFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        JsonFactory $jsonFactory,
        ContactResourceModel $contactResourceModel
    ) {
        $this->dataObjectProcessor  = $dataObjectProcessor;
        $this->dataObjectHelper     = $dataObjectHelper;
        $this->jsonFactory          = $jsonFactory;
        $this->contactResourceModel = $contactResourceModel;
        parent::__construct($context, $coreRegistry, $contactRepository, $resultPageFactory);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $contactId) {
            /** @var \Magentomaster\Testmodule\Model\Contact|\Magentomaster\Testmodule\Api\Data\ContactInterface $contact */
            $contact = $this->contactRepository->getById((int)$contactId);
            try {
                $contactData = $postItems[$contactId];
                $this->dataObjectHelper->populateWithArray($contact, $contactData, ContactInterface::class);
                $this->contactResourceModel->saveAttribute($contact, array_keys($contactData));
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithContactId($contact, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithContactId($contact, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithContactId(
                    $contact,
                    __('Something went wrong while saving the Contact.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Contact id to error message
     *
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithContactId(ContactInterface $contact, $errorText)
    {
        return '[Contact ID: ' . $contact->getId() . '] ' . $errorText;
    }
}
