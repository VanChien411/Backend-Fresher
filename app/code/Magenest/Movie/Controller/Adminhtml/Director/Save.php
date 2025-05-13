<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Movie\Model\DirectorFactory;

class Save extends Action
{
    protected $directorFactory;

    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory
    ) {
        $this->directorFactory = $directorFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $directorId = isset($data['data']['director_id']) ? $data['data']['director_id'] : null;
                $director = $this->directorFactory->create();

                if ($directorId) {
                    $director->load($directorId);
                    if (!$director->getId()) {
                        throw new LocalizedException(__('This director no longer exists.'));
                    }
                } else {
                    // Đảm bảo không truyền director_id khi tạo mới
                    unset($data['data']['director_id']);
                }

                $director->setData($data['data']);
                $director->save();

                $this->messageManager->addSuccessMessage(__('The director has been saved successfully.'));
                $this->_getSession()->unsFormData();

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $director->getId()]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $directorId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the director.'));
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $directorId]);
            }
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
