<?php

namespace Magenest\Movie\Block\Adminhtml;

class Movie extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_Movie';
        $this->_controller = 'adminhtml_movie';
        $this->_headerText = __('Manage Movies');
        $this->_addButtonLabel = __('Add New Movie');
        parent::_construct();
    }
}
