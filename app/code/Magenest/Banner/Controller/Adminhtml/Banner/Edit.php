<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Banner\Model\BannerFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $bannerFactory;

    public function __construct(
        Context       $context,
        PageFactory   $resultPageFactory,
        BannerFactory $bannerFactory
    )
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $banner = $this->bannerFactory->create();

        if ($id) {
            $banner->load($id);
            if (!$banner->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Banner::banner_manage');
        $resultPage->addBreadcrumb(__('Banner'), __('Banner'));
        $resultPage->addBreadcrumb(__('Manage Banner'), __('Manage Banner'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Banner') : __('Add New Banner'));

        return $resultPage;
    }
}
