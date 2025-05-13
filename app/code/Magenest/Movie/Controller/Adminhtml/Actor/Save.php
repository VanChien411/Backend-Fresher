<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Movie\Model\ActorFactory;

class Save extends Action
{
    protected $actorFactory;

    public function __construct(
        Action\Context $context,
        ActorFactory $actorFactory
    ) {
        $this->actorFactory = $actorFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $actorId = isset($data['data']['actor_id']) ? $data['data']['actor_id'] : null;
                $actor = $this->actorFactory->create();

                if ($actorId) {
                    $actor->load($actorId);
                    if (!$actor->getId()) {
                        throw new LocalizedException(__('This actor no longer exists.'));
                    }
                } else {
                    // Đảm bảo không truyền actor_id khi tạo mới
                    unset($data['data']['actor_id']);
                }

                $actor->setData($data['data']);
                $actor->save();

                $this->messageManager->addSuccessMessage(__('The actor has been saved successfully.'));
                $this->_getSession()->unsFormData();

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $actor->getId()]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $actorId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the actor.'));
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $actorId]);
            }
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
