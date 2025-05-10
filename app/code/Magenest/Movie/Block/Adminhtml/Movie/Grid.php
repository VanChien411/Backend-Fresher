<?php

namespace Magenest\Movie\Block\Adminhtml\Movie;

use Magento\Backend\Block\Widget\Grid\Extended;

class Grid extends Extended
{
    /**
     * @var \Magenest\Movie\Model\ResourceModel\Movie\Collection
     */
    protected $_movieCollection;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magenest\Movie\Model\ResourceModel\Movie\Collection $movieCollection,
        array $data = []
    ) {
        $this->_movieCollection = $movieCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Movies Found'));
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_movieCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'movie_id',
            [
                'header' => __('ID'),
                'index' => 'movie_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Movie Name'),
                'index' => 'name',
            ]
        );
        $this->addColumn(
            'description',
            [
                'header' => __('Description'),
                'index' => 'description',
            ]
        );
        $this->addColumn(
            'rating',
            [
                'header' => __('Rating'),
                'index' => 'rating',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'director_id',
            [
                'header' => __('Director ID'),
                'index' => 'director_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'director_name',
            [
                'header' => __('Director Name'),
                'index' => 'director_name',
                'type' => 'text',
            ]
        );

        return parent::_prepareColumns();
    }
}
