<?php

namespace Magenest\Blog\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Magenest\Blog\Model\Category::class,
            \Magenest\Blog\Model\ResourceModel\Category::class
        );
    }
}
