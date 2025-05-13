<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\DirectorFactory;

class Add extends Action
{
    protected $resultPageFactory;
    protected $directorFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DirectorFactory $directorFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->directorFactory = $directorFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $director = $this->directorFactory->create();

        if ($id) {
            $director->load($id);
            if (!$director->getId()) {
                $this->messageManager->addErrorMessage(__('This director no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }


        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Movie::director');

        $resultPage->addBreadcrumb(
            __('Director'),
            __('Director')
        );

        $resultPage->addBreadcrumb(__('ManageDirectors'), __('Manage Directors'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Director') : __('Add New Director'));
        return $resultPage;
    }
}
