<?php

namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;

class Movie extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(resourceModel: \Magenest\Movie\Model\ResourceModel\Movie::class);
    }
}
