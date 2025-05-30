<?php

namespace Magenest\CourseTime\Block\Adminhtml\System\Config;

use Magento\Framework\View\Element\Html\Select;

class DatePicker extends \Magento\Framework\View\Element\Html\Select
{
    public function _toHtml()
    {
        $value = $this->getEscapedValue() ?: date('Y-m-d\TH:i:s'); // Giá trị mặc định là ngày giờ hiện tại (2025-05-30T11:28:00)
        $inputId = $this->getData("input_id");
        $name = $this->getData("input_name");

        // HTML structure: sử dụng input type="datetime-local" để chọn ngày giờ
        $html = <<<HTML
<input type="datetime-local" id="{$inputId}" name="{$name}" value="{$value}" style="width: 200px;" />
HTML;

        return $html;
    }
}