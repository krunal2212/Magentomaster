<?php
namespace Magentomaster\Testmodule\Api\Data;

/**
 * @api
 */
interface ContactInterface
{
    /**
     * ID
     *
     * @var string
     */
    const CONTACT_ID = 'contact_id';

    /**
     * Name attribute constant
     *
     * @var string
     */
    const NAME = 'name';

    /**
     * Email attribute constant
     *
     * @var string
     */
    const EMAIL = 'email';

    /**
     * Phone attribute constant
     *
     * @var string
     */
    const PHONE = 'phone';

    /**
     * Message attribute constant
     *
     * @var string
     */
    const MESSAGE = 'message';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getContactId();

    /**
     * Set ID
     *
     * @param int $contactId
     * @return ContactInterface
     */
    public function setContactId($contactId);

    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Set Name
     *
     * @param mixed $name
     * @return ContactInterface
     */
    public function setName($name);

    /**
     * Get Email
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set Email
     *
     * @param mixed $email
     * @return ContactInterface
     */
    public function setEmail($email);

    /**
     * Get Phone
     *
     * @return mixed
     */
    public function getPhone();

    /**
     * Set Phone
     *
     * @param mixed $phone
     * @return ContactInterface
     */
    public function setPhone($phone);

    /**
     * Get Message
     *
     * @return mixed
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param mixed $message
     * @return ContactInterface
     */
    public function setMessage($message);
}
