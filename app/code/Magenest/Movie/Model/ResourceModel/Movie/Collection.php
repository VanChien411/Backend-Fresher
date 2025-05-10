<?php

namespace Magenest\Movie\Model\ResourceModel\Movie;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Movie\Model\Movie as MovieModel;
use Magenest\Movie\Model\ResourceModel\Movie as MovieResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(MovieModel::class, MovieResource::class);
    }
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->joinLeft(
            ['director' => $this->getTable('magenest_director')],
            'main_table.director_id = director.director_id',
            ['director_name' => 'director.name']
        );
        return $this;
    }
}
