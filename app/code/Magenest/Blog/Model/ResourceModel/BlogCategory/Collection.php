<?php

namespace Magenest\Blog\Model\ResourceModel\BlogCategory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Magenest\Blog\Model\BlogCategory::class,
            \Magenest\Blog\Model\ResourceModel\BlogCategory::class
        );
    }
}
