<?php

namespace Magenest\CourseTime\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRows extends AbstractFieldArray
{
    /**
     * @var \Magenest\CourseTime\Block\Adminhtml\System\Config\Form\Field\CustomerGroup
     */
    protected $groupRenderer;

    /**
     * @var \Magenest\CourseTime\Block\Adminhtml\System\Config\DatePicker
     */
    protected $dateRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn('customer_group_id', [
            'label' => __('Customer Group'),
            'renderer' => $this->getGroupRenderer()
        ]);
        $this->addColumn('start_time', [
            'label' => __('Start Time'),
            'renderer' => $this->getDateRenderer(),
            'class' => 'required-entry'
        ]);
        $this->addColumn('end_time', [
            'label' => __('End Time'),
            'renderer' => $this->getDateRenderer(),
            'class' => 'required-entry'
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Access Time');
    }

    protected function getGroupRenderer()
    {
        if (!$this->groupRenderer) {
            $this->groupRenderer = $this->getLayout()->createBlock(
                \Magenest\CourseTime\Block\Adminhtml\System\Config\Form\Field\CustomerGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->groupRenderer->setClass('customer-group-select');
        }
        return $this->groupRenderer;
    }

    protected function getDateRenderer()
    {
        if (!$this->dateRenderer) {
            $this->dateRenderer = $this->getLayout()->createBlock(
                \Magenest\CourseTime\Block\Adminhtml\System\Config\DatePicker::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->dateRenderer;
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