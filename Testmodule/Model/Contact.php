<?php
namespace Magentomaster\Testmodule\Model;

use Magento\Framework\Model\AbstractModel;
use Magentomaster\Testmodule\Api\Data\ContactInterface;

class Contact extends AbstractModel implements ContactInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'magentomaster_testmodule_contact';

    /**
     * Cache tag
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'magentomaster_testmodule_contact';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'contact';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magentomaster\Testmodule\Model\ResourceModel\Contact::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Contact id
     *
     * @return array
     */
    public function getContactId()
    {
        return $this->getData(ContactInterface::CONTACT_ID);
    }

    /**
     * set Contact id
     *
     * @param int $contactId
     * @return ContactInterface
     */
    public function setContactId($contactId)
    {
        return $this->setData(ContactInterface::CONTACT_ID, $contactId);
    }

    /**
     * set Name
     *
     * @param mixed $name
     * @return ContactInterface
     */
    public function setName($name)
    {
        return $this->setData(ContactInterface::NAME, $name);
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(ContactInterface::NAME);
    }

    /**
     * set Email
     *
     * @param mixed $email
     * @return ContactInterface
     */
    public function setEmail($email)
    {
        return $this->setData(ContactInterface::EMAIL, $email);
    }

    /**
     * get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(ContactInterface::EMAIL);
    }

    /**
     * set Phone
     *
     * @param mixed $phone
     * @return ContactInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(ContactInterface::PHONE, $phone);
    }

    /**
     * get Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(ContactInterface::PHONE);
    }

    /**
     * set Message
     *
     * @param mixed $message
     * @return ContactInterface
     */
    public function setMessage($message)
    {
        return $this->setData(ContactInterface::MESSAGE, $message);
    }

    /**
     * get Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(ContactInterface::MESSAGE);
    }
}
