<?php

namespace Magenest\Blog\Controller\Adminhtml\Blog;

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
        $resultPage->setActiveMenu('Magenest_Blog::blog');
        $resultPage->addBreadcrumb(
            __('Blog'),
            __('Blog')
        );
        $resultPage->addBreadcrumb(__('ManageBlogs'), __('Manage Blogs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));
        return $resultPage;
    }
    // protected function _isAllowed()
    // {
    //     return $this->_authorization->isAllowed('Magenest_Movie::movie_list');
    // }
}
