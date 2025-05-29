<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Banner\Model\BannerFactory;

class Delete extends Action
{
    protected $bannerFactory;

    public function __construct(
        Action\Context $context,
        BannerFactory  $bannerFactory
    )
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Execute delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $banner = $this->bannerFactory->create()->load($id);

            if (!$banner->getId()) {
                throw new LocalizedException(__('This banner no longer exists.'));
            }

            $banner->delete();

            $this->messageManager->addSuccessMessage(__('The banner has been deleted.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while deleting the banner.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
