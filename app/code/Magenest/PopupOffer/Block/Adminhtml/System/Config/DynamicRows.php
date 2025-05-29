<?php

namespace Magenest\PopupOffer\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRows extends AbstractFieldArray
{
    /**
     * @var \Magento\Framework\View\Element\Html\Select
     */
    protected $groupRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn('customer_group_id', [
            'label' => __('Customer Group'),
            'renderer' => $this->getGroupRenderer()
        ]);
        $this->addColumn('message', [
            'label' => __('Offer Message'),
            'class' => 'required-entry'
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Offer');
    }

    protected function getGroupRenderer()
    {
        if (!$this->groupRenderer) {
            $this->groupRenderer = $this->getLayout()->createBlock(
                \Magenest\PopupOffer\Block\Adminhtml\System\Config\Form\Field\CustomerGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->groupRenderer->setClass('customer-group-select');
        }
        return $this->groupRenderer;
    }

    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];
        $groupId = $row->getData('customer_group_id');

        if ($groupId !== null) {
            $hash = $this->getGroupRenderer()->calcOptionHash($groupId);
            $options['option_' . $hash] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }
}
