<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Banner\Model\BannerFactory;

class Save extends Action
{
    protected $bannerFactory;

    public function __construct(
        Action\Context $context,
        BannerFactory  $bannerFactory
    )
    {
        $this->bannerFactory = $bannerFactory;
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
            $banner = $this->bannerFactory->create();

            if ($id) {
                $banner->load($id);
                if (!$banner->getId()) {
                    throw new LocalizedException(__('This Banner no longer exists.'));
                }
            } else {
                unset($data['data']['id']);
            }
// Xử lý ảnh trước khi gán dữ liệu
            if (isset($data['data']['image']) && is_array($data['data']['image'])) {
                $data['data']['image'] = $data['data']['image'][0]['url'] ?? null;
            }

            $banner->setData($data['data']);

            $this->_eventManager->dispatch(
                'magenest_banner_save_before',
                ['banner' => $banner]
            );

            $banner->save();

            $this->_eventManager->dispatch(
                'magenest_banner_save_after',
                ['banner' => $banner]
            );

            $this->messageManager->addSuccessMessage(__('The banner has been saved.'));
            $this->_getSession()->unsFormData();

            return $this->processReturn($resultRedirect, $banner->getId());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the banner.'));
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
