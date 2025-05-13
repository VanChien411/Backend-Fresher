<?php

namespace Magenest\Movie\Block\Adminhtml;

class Director extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_Movie';
        $this->_controller = 'adminhtml_director';
        $this->_headerText = __('Manage Directors');
        $this->addButton('add', [
            'label' => __('Add New Director'),
            'onclick' => 'setLocation(\'' . $this->getUrl(route: '*/*/add') . '\')',
            'class' => 'primary'
        ]);
        // parent::_construct();

        // // Xóa nút Add mặc định
        // $this->buttonList->remove('add');
    }
}
