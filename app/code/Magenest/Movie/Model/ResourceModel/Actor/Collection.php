<?php

namespace Magenest\Movie\Model\ResourceModel\Actor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Actor as ActorModel;
use Magenest\Movie\Model\ResourceModel\Actor as ActorResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(ActorModel::class, ActorResource::class);
    }
}
