<?php

namespace Magenest\Movie\Block\Adminhtml;

class Actor extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_Movie';
        $this->_controller = 'adminhtml_actor';
        $this->_headerText = __('Manage Actors');
        $this->addButton('add', [
            'label' => __('Add New Actor'),
            'onclick' => 'setLocation(\'' . $this->getUrl(route: '*/*/add') . '\')',
            'class' => 'primary'
        ]);
        // parent::_construct();

        // // Xóa nút Add mặc định
        // $this->buttonList->remove('add');
    }
}
