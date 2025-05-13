<?php

namespace Magenest\Movie\Block\Adminhtml\Actor;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magenest\Movie\Model\ResourceModel\Actor\Collection as ActorCollection;

class Grid extends Extended
{
    protected $_actorCollection;

    public function __construct(
        Context $context,
        Data $backendHelper,
        ActorCollection $actorCollection,
        array $data = []
    ) {
        $this->_actorCollection = $actorCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Actors Found'));
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_actorCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'actor_id',
            [
                'header' => __('ID'),
                'index' => 'actor_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Actor Name'),
                'index' => 'name',
                'type' => 'text',
            ]
        );

        return parent::_prepareColumns();
    }
}
