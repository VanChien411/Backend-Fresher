<?php

namespace Magenest\ColorSwitch\Block\Adminhtml\System\Config;

use Magento\Framework\View\Element\Html\Select;

class ColorPicker extends \Magento\Framework\View\Element\Html\Select
{
    public function _toHtml()
    {
        $value = $this->getEscapedValue() ?: '#000000';
        $inputId = $this->getData("input_id");
        $name = $this->getData("input_name");

        // HTML structure: wrapper div with background, hex code text, and color input
        $html = <<<HTML
<div class="color-picker-wrapper" data-input-id="{$inputId}" style="background-color: {$value}; cursor: pointer; width: 100px; height: 30px; line-height: 30px; text-align: center; border: 1px solid #ccc; border-radius: 4px; position: relative;">
    <span style="color: #fff; text-shadow: 1px 1px 1px #000;">{$value}</span>
  <input type="color" id="{$inputId}" name="{$name}" value="{$value}" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;" />

</div>
<script type="text/javascript">
    require(['jquery'], function($) {
        $(document).ready(function() {
            $('.color-picker-wrapper').each(function() {
                var wrapper = $(this);
                var input = wrapper.find('input[type="color"]');

                // Lấy giá trị thực tế từ input khi trang vừa load
                var initialColor = input.val();
                wrapper.css('background-color', initialColor);
                wrapper.find('span').text(initialColor);

                input.on('click', function(e) {
                    e.stopPropagation();
                });

                wrapper.on('click', function(e) {
                    e.preventDefault();
                    input.trigger('click');
                });

                input.on('input change', function() {
                    var newColor = $(this).val();
                    wrapper.css('background-color', newColor);
                    wrapper.find('span').text(newColor);
                });
            });
        });
    });
</script>


HTML;

        return $html;
    }
}