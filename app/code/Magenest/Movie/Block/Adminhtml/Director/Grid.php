<?php

namespace Magenest\Movie\Block\Adminhtml\Director;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magenest\Movie\Model\ResourceModel\Director\Collection as DirectorCollection;

class Grid extends Extended
{
    protected $_directorCollection;

    public function __construct(
        Context $context,
        Data $backendHelper,
        DirectorCollection $directorCollection,
        array $data = []
    ) {
        $this->_directorCollection = $directorCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Directors Found'));
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_directorCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'director_id',
            [
                'header' => __('ID'),
                'index' => 'director_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Director Name'),
                'index' => 'name',
                'type' => 'text',
            ]
        );

        return parent::_prepareColumns();
    }
}
