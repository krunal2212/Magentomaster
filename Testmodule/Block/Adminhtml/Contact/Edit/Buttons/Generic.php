<?php
namespace Magentomaster\Testmodule\Block\Adminhtml\Contact\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magentomaster\Testmodule\Api\ContactRepositoryInterface;

class Generic
{
    /**
     * Widget Context
     *
     * @var Context
     */
    protected $context;

    /**
     * Contact Repository
     *
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * constructor
     *
     * @param Context $context
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(
        Context $context,
        ContactRepositoryInterface $contactRepository
    ) {
        $this->context           = $context;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Return Contact ID
     *
     * @return int|null
     */
    public function getContactId()
    {
        try {
            return $this->contactRepository->getById(
                $this->context->getRequest()->getParam('contact_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
