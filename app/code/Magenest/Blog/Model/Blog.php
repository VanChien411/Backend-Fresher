<?php

namespace Magenest\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewrite as UrlRewriteResource;
use Magento\Store\Model\StoreManagerInterface;

class Blog extends AbstractModel
{
    /**
     * @var User|null
     */
    protected $author = null;

    /**
     * @var UserFactory
     */
    protected $userFactory;

    public function __construct(
        CollectionFactory                                       $CollectionFactory,
        \Magento\Framework\Model\Context                        $context,
        \Magento\Framework\Registry                             $registry,
        UrlRewriteFactory                                       $urlRewriteFactory,
        UrlRewriteResource                                      $urlRewriteResource,
        UserFactory                                             $userFactory,
        StoreManagerInterface                                   $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection = null,
        array                                                   $data = []

    )
    {
        $this->collectionFactory = $CollectionFactory;
        $this->userFactory = $userFactory;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->urlRewriteResource = $urlRewriteResource;
        $this->storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Get full Author model (admin_user)
     *
     * @return User|null
     */


    public function beforeSave()
    {
        $now = date('Y-m-d H:i:s');
        if (!$this->getId()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);

        // Kiểm tra trùng url_rewrite trước khi lưu
        $urlRewrite = $this->getUrlRewrite();
        $id = $this->getId();

        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('url_rewrite', $urlRewrite);

        if ($id) {
            $collection->addFieldToFilter('id', ['neq' => $id]);
        }

        if ($collection->getSize()) {
            throw new LocalizedException(__('URL rewrite "%1" already exists.', $urlRewrite));
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        $entityId = $this->getId();
        $requestPath = $this->getUrlRewrite();

        foreach ($this->storeManager->getStores() as $store) {
            $storeId = $store->getId();

            $collection = $this->urlRewriteFactory->create()->getCollection()
                ->addFieldToFilter('entity_type', 'custom')
                ->addFieldToFilter('entity_id', $entityId)
                ->addFieldToFilter('store_id', $storeId);

            // Xóa nếu request_path thay đổi
            foreach ($collection as $oldRewrite) {
                if ($oldRewrite->getRequestPath() != $requestPath) {
                    $this->urlRewriteResource->delete($oldRewrite);
                } else {
                    // Nếu đã tồn tại đúng request_path thì không cần tạo mới
                    continue 2;
                }
            }

            // Kiểm tra trùng request_path với các entity khác
            $existingPath = $this->urlRewriteFactory->create()->getCollection()
                ->addFieldToFilter('request_path', $requestPath)
                ->addFieldToFilter('store_id', $storeId)
                ->addFieldToFilter('entity_id', ['neq' => $entityId])
                ->addFieldToFilter('entity_type', 'custom')
                ->getFirstItem();

            if ($existingPath && $existingPath->getId()) {
                throw new LocalizedException(__('URL Rewrite "%1" already exists in store %2', $requestPath, $store->getName()));
            }

            // Tạo mới url rewrite
            $rewrite = $this->urlRewriteFactory->create();
            $rewrite->setEntityType('custom')
                ->setEntityId($entityId)
                ->setRequestPath($requestPath)
                ->setTargetPath("blog/blog/view/id/{$entityId}")
                ->setStoreId($storeId)
                ->setIsSystem(0);

            $this->urlRewriteResource->save($rewrite);
        }

        return parent::afterSave();
    }


    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\ResourceModel\Blog::class);
    }
}
