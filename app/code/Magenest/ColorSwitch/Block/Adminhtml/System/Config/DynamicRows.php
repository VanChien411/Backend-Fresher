<?php

namespace Magenest\ColorSwitch\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRows extends AbstractFieldArray
{
    /** @var \Magento\Framework\View\Element\Html\Select */
    protected $hexRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn('label', [
            'label' => __('Color Name'),
            'class' => 'required-entry'
        ]);
        $this->addColumn('code', [
            'label' => __('Color Code'),
            'renderer' => $this->getColorPickerRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Color');
    }

    protected function getColorPickerRenderer()
    {
        if (!$this->hexRenderer) {
            $this->hexRenderer = $this->getLayout()->createBlock(
                \Magenest\ColorSwitch\Block\Adminhtml\System\Config\ColorPicker::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->hexRenderer->setClass('colorpicker-class'); // optional
            $this->hexRenderer->setExtraParams('style="width:120px"'); // optional
        }
        return $this->hexRenderer;
    }

    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];

        $code = $row->getData('code');
        if ($code) {
            // Truyền giá trị color code qua data attribute
            $options['data-color'] = $code;
        }

        $row->setData('option_extra_attrs', $options);
    }


}
