<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\ActorFactory;

class Add extends Action
{
    protected $resultPageFactory;
    protected $actorFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory,    ActorFactory $actorFactory)
    {
        parent::__construct($context);
        $this->actorFactory = $actorFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $actor = $this->actorFactory->create();

        if ($id) {
            $actor->load($id);
            if (!$actor->getId()) {
                $this->messageManager->addErrorMessage(__('This actor no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Movie::actor');
        $resultPage->addBreadcrumb(
            __('Actor'),
            __('Actor')
        );

        $resultPage->addBreadcrumb(__('ManageActors'), __('Manage Actors'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Actor') : __('Add New Actor'));
        return $resultPage;
    }
}
