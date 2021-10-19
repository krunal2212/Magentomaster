<?php
namespace Magentomaster\Testmodule\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magentomaster\Testmodule\Api\Data\ContactInterface;

/**
 * @api
 */
interface ContactRepositoryInterface
{
    /**
     * Save Contact.
     *
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @return \Magentomaster\Testmodule\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ContactInterface $contact);

    /**
     * Retrieve Contact
     *
     * @param int $contactId
     * @return \Magentomaster\Testmodule\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($contactId);

    /**
     * Retrieve Form matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magentomaster\Testmodule\Api\Data\ContactSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Contact.
     *
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface $contact
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ContactInterface $contact);

    /**
     * Delete Contact by ID.
     *
     * @param int $contactId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($contactId);
}
