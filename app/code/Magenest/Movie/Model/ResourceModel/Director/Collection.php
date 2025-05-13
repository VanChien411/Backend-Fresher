<?php

namespace Magenest\Movie\Model\ResourceModel\Director;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Director as DirectorModel;
use Magenest\Movie\Model\ResourceModel\Director as DirectorResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(DirectorModel::class, DirectorResourceModel::class);
    }

}
