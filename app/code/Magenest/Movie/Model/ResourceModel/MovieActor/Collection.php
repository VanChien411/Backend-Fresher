<?php

namespace Magenest\Movie\Model\ResourceModel\MovieActor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\MovieActor as MovieActorModel;
use Magenest\Movie\Model\ResourceModel\MovieActor as MovieActorResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(MovieActorModel::class, MovieActorResource::class);
    }
}
