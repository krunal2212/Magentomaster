<?php
namespace Magentomaster\Testmodule\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterfaceFactory;
use Magentomaster\Testmodule\Api\Data\ContactSearchResultInterfaceFactory;
use Magentomaster\Testmodule\Model\ResourceModel\Contact as ContactResourceModel;
use Magentomaster\Testmodule\Model\ResourceModel\Contact\Collection;
use Magentomaster\Testmodule\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Cached instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Contact resource model
     *
     * @var ContactResourceModel
     */
    protected $resource;

    /**
     * Contact collection factory
     *
     * @var ContactCollectionFactory
     */
    protected $contactCollectionFactory;

    /**
     * Contact interface factory
     *
     * @var ContactInterfaceFactory
     */
    protected $contactInterfaceFactory;

    /**
     * Data Object Helper
     *
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     *
     * @var ContactSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * constructor
     *
     * @param ContactResourceModel $resource
     * @param ContactCollectionFactory $contactCollectionFactory
     * @param ContactInterfaceFactory $contactInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ContactSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ContactResourceModel $resource,
        ContactCollectionFactory $contactCollectionFactory,
        ContactInterfaceFactory $contactInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        ContactSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->resource                 = $resource;
        $this->contactCollectionFactory = $contactCollectionFactory;
        $this->contactInterfaceFactory  = $contactInterfaceFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
        $this->searchResultsFactory     = $searchResultsFactory;
    }

    /**
     * Save Contact.
     *
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @return \Magentomaster\Testmodule\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ContactInterface $contact)
    {
        /** @var ContactInterface|\Magento\Framework\Model\AbstractModel $contact */
        try {
            $this->resource->save($contact);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Contact: %1',
                $exception->getMessage()
            ));
        }
        return $contact;
    }

    /**
     * Retrieve Contact.
     *
     * @param int $contactId
     * @return \Magentomaster\Testmodule\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($contactId)
    {
        if (!isset($this->instances[$contactId])) {
            /** @var ContactInterface|\Magento\Framework\Model\AbstractModel $contact */
            $contact = $this->contactInterfaceFactory->create();
            $this->resource->load($contact, $contactId);
            if (!$contact->getId()) {
                throw new NoSuchEntityException(__('Requested Contact doesn\'t exist'));
            }
            $this->instances[$contactId] = $contact;
        }
        return $this->instances[$contactId];
    }

    /**
     * Retrieve Form matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magentomaster\Testmodule\Api\Data\ContactSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Magentomaster\Testmodule\Api\Data\ContactSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Magentomaster\Testmodule\Model\ResourceModel\Contact\Collection $collection */
        $collection = $this->contactCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'contact_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var ContactInterface[] $form */
        $form = [];
        /** @var \Magentomaster\Testmodule\Model\Contact $contact */
        foreach ($collection as $contact) {
            /** @var ContactInterface $contactDataObject */
            $contactDataObject = $this->contactInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $contactDataObject,
                $contact->getData(),
                ContactInterface::class
            );
            $form[] = $contactDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($form);
    }

    /**
     * Delete Contact.
     *
     * @param ContactInterface $contact
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ContactInterface $contact)
    {
        /** @var ContactInterface|\Magento\Framework\Model\AbstractModel $contact */
        $id = $contact->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($contact);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove Contact %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete Contact by ID.
     *
     * @param int $contactId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($contactId)
    {
        $contact = $this->getById($contactId);
        return $this->delete($contact);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}
