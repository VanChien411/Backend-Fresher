<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\MovieFactory;

class Add extends Action
{
    protected $resultPageFactory;
    protected $movieFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory,    MovieFactory $movieFactory)
    {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $movie = $this->movieFactory->create();

        if ($id) {
            $movie->load($id);
            if (!$movie->getId()) {
                $this->messageManager->addErrorMessage(__('This movie no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Movie::movie_list');
        $resultPage->addBreadcrumb(
            __('Movie'),
            __('Movie')
        );

        $resultPage->addBreadcrumb(__('ManageMovies'), __('Manage Movies'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Movie') : __('Add New Movie'));
        return $resultPage;
    }
    // protected function _isAllowed()
    // {
    //     return $this->_authorization->isAllowed('Magenest_Movie::movie_list');
    // }
}
