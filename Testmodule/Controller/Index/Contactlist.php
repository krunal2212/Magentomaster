<?php declare(strict_types=1);

namespace Magentomaster\Testmodule\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Contactlist implements HttpGetActionInterface
{
    /** @var PageFactory */
    private $pageFactory;
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__('Submitted Form List'));
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
