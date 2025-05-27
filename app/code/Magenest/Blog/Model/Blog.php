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
        // 1. Xóa các rewrite cũ (nếu có)
        $existingCollection = $this->urlRewriteFactory->create()->getCollection()
            ->addFieldToFilter('entity_type', 'custom')
            ->addFieldToFilter('entity_id', $this->getId())
            ->addFieldToFilter('store_id', 1);

        /** @var \Magento\UrlRewrite\Model\UrlRewrite $old */
        foreach ($existingCollection as $old) {
            $this->urlRewriteResource->delete($old);
        }

        // 2a. Cách 1: tạo cho từng store view
        foreach ($this->storeManager->getStores() as $store) {
            $rewrite = $this->urlRewriteFactory->create();
            $rewrite->setEntityType('custom')
                ->setEntityId($this->getId())
                ->setRequestPath($this->getUrlRewrite())
                ->setTargetPath("blog/blog/view/id/{$this->getId()}")
                ->setStoreId($store->getId())
                ->setIsSystem(0);
            $this->urlRewriteResource->save($rewrite);
        }

        // 3. Invalidate cache
//        $this->cacheTypeList->invalidate('full_page');

        return parent::afterSave();
    }


    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\ResourceModel\Blog::class);
    }
}
