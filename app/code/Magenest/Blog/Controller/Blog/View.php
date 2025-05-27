<?php

namespace Magenest\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Blog\Model\BlogFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class View extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    /** @var BlogFactory */
    protected $blogFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return $this->_redirect('noroute');
        }

        try {
            $blog = $this->blogFactory->create()->load($id);
            if (!$blog->getId()) {
                throw new NoSuchEntityException();
            }
        } catch (NoSuchEntityException $e) {
            return $this->_redirect('noroute');
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($blog->getTitle());
        // Make blog data available to block/template
        $resultPage->getLayout()->getBlock('magenest_blog.view')->setBlog($blog);
        return $resultPage;
    }
}
