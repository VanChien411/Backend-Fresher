<?php

namespace Magenest\Banner\Controller\Adminhtml\Banner\Image;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\Framework\App\Filesystem\DirectoryList as DL;

class Upload extends Action
{
    protected $resultJsonFactory;
    protected $uploaderFactory;
    protected $mediaDirectory;

    public function __construct(
        Action\Context  $context,
        JsonFactory     $resultJsonFactory,
        UploaderFactory $uploaderFactory,
        Filesystem      $filesystem
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DL::MEDIA);
    }

    public function execute()
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'data[image]']);

            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false); // không phân tán file

            $target = 'magenest/banner'; // folder trong pub/media
            $absolutePath = $this->mediaDirectory->getAbsolutePath($target);

            // ✅ Đảm bảo thư mục tồn tại
            if (!$this->mediaDirectory->isExist($target)) {
                $this->mediaDirectory->create($target);
            }

            $result = $uploader->save($absolutePath);

            $result['url'] = $this->_url->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . $target . '/' . $result['file'];
            $result['file'] = $target . '/' . $result['file'];

            return $this->resultJsonFactory->create()->setData($result);
        } catch (\Exception $e) {
            return $this->resultJsonFactory->create()->setData([
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode(),
            ]);
        }
    }

}
