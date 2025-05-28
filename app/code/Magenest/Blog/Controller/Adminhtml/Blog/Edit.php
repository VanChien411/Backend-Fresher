<?php

namespace Magenest\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Blog\Model\BlogFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $blogFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    )
    {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $blog = $this->blogFactory->create();

        if ($id) {
            $blog->load($id);
            if (!$blog->getId()) {
                $this->messageManager->addErrorMessage(__('This blog no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Blog::blog');
        $resultPage->addBreadcrumb(__('Blog'), __('Blog'));
        $resultPage->addBreadcrumb(__('Manage Blog'), __('Manage Blog'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Blog') : __('Add New Blog'));

        return $resultPage;
    }
}