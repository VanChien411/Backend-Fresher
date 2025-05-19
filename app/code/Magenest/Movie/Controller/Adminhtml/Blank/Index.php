<?php

namespace Magenest\Movie\Controller\Adminhtml\Blank;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Movie::integration');
        $resultPage->addBreadcrumb(
            __('Blank'),
            __('Blank')
        );
        $resultPage->addBreadcrumb(__('Blank_Page'), __('Blank Page'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blank Page'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::integration');
    }
}
