<?php

namespace Magenest\Movie\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ReloadButton extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $buttonId = 'reload_page_button';
        $buttonLabel = __('Reload Page');
        $html = <<<HTML
<button id="{$buttonId}" type="button" class="scalable" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">
    <span>{$buttonLabel}</span>
</button>
<script type="text/javascript">
    require(['jquery'], function($) {
        $('#{$buttonId}').on('click', function() {
            location.reload();
        });
    });
</script>
HTML;
        return $html;
    }
}
