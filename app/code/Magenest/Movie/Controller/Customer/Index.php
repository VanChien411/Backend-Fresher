<?php

namespace Magenest\Movie\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class Index extends Action
{
    protected $resultPageFactory;
    protected $customerSession;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        Session     $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Account Dashboard'));
        return $resultPage;
    }


}
