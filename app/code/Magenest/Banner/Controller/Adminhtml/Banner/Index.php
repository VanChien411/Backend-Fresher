<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

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
        $resultPage->setActiveMenu('Magenest_Banner::banner_manage');
        $resultPage->addBreadcrumb(
            __('Banner'),
            __('Banner')
        );
        $resultPage->addBreadcrumb(__('ManageBanners'), __('Manage Banners'));
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));
        return $resultPage;
    }
    // protected function _isAllowed()
    // {
    //     return $this->_authorization->isAllowed('Magenest_Movie::movie_list');
    // }
}
