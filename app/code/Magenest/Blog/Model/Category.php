<?php

namespace Magenest\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Category extends AbstractModel
{


    protected function _construct()
    {
        $this->_init(\Magenest\Blog\Model\ResourceModel\Category::class);
    }
}
