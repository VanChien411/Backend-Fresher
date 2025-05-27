<?php

namespace Magenest\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Blog\Model\BlogFactory;

class Save extends Action
{
    protected $blogFactory;

    public function __construct(
        Action\Context $context,
        BlogFactory $blogFactory
    ) {
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data = $this->getRequest()->getPostValue()) {
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $id = $data['data']['id'] ?? null;
            $blog = $this->blogFactory->create();

            if ($id) {
                $blog->load($id);
                if (!$blog->getId()) {
                    throw new LocalizedException(__('This blog no longer exists.'));
                }
            } else {
                unset($data['data']['id']);
            }

            $blog->setData($data['data']);

            $this->_eventManager->dispatch(
                'magenest_blog_save_before',
                ['blog' => $blog]
            );

            $blog->save();

            $this->_eventManager->dispatch(
                'magenest_blog_save_after',
                ['blog' => $blog]
            );

            $this->messageManager->addSuccessMessage(__('The blog has been saved.'));
            $this->_getSession()->unsFormData();

            return $this->processReturn($resultRedirect, $blog->getId());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the blog.'));
        }

        $this->_getSession()->setFormData($data);
        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
    }

    private function processReturn($resultRedirect, $id)
    {
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
