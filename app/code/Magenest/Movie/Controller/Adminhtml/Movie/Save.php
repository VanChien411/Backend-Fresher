<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Movie\Model\MovieFactory;

class Save extends Action
{
    protected $movieFactory;

    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory
    ) {
        $this->movieFactory = $movieFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $movieId = isset($data['data']['movie_id']) ? $data['data']['movie_id'] : null;
                $movie = $this->movieFactory->create();

                // Load movie nếu chỉnh sửa
                if ($movieId) {
                    $movie->load($movieId);
                    if (!$movie->getId()) {
                        throw new LocalizedException(__('This movie no longer exists.'));
                    }
                } else {
                    // Remove movie_id
                    unset($data['data']['movie_id']);
                }


                // Gán dữ liệu từ form
                $movie->setData($data['data']);

                // Gán event trước khi lưu
                $this->_eventManager->dispatch(
                    'magenest_movie_save',
                    ['movie' => $movie]
                );

                // Lưu vào database
                $movie->save();

                // Thông báo thành công
                $this->messageManager->addSuccessMessage(__('The movie has been saved successfully.'));

                // Xóa session form data
                $this->_getSession()->unsFormData();

                // Chuyển hướng về danh sách hoặc form chỉnh sửa
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $movie->getId()]);
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                // Lưu dữ liệu vào session để giữ lại khi lỗi
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $movieId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the movie.'));
                $this->_getSession()->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $movieId]);
            }
        }

        // Nếu không có dữ liệu, chuyển hướng về danh sách
        return $resultRedirect->setPath('*/*/index');
    }
}
