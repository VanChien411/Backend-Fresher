<?php

namespace Magenest\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class BlogCategory extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\ResourceModel\BlogCategory::class);
    }
}
