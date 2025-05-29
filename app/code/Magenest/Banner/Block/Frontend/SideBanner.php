<?php

namespace Magenest\Banner\Block\Frontend;

use Magento\Framework\View\Element\Template;
use Magenest\Banner\Model\ResourceModel\Banner\CollectionFactory;

class SideBanner extends Template
{
    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context  $context,
        CollectionFactory $bannerCollectionFactory,
        array             $data = []
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getEnabledBanners()
    {
        return $this->bannerCollectionFactory->create()
            ->addFieldToFilter('is_enabled', 1)
            ->setPageSize(2); // chỉ lấy 2 banner
    }
}
