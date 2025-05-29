<?php

namespace Magenest\ColorSwitch\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Switcher extends Template
{
    const XML_PATH_COLORS = 'color_switch/color_options/colors';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context     $context,
        ScopeConfigInterface $scopeConfig,
        array                $data = []
    )
    {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Trả về mảng các option: [['label'=>'Red','code'=>'#ff0000'], …]
     */
    public function getColorOptions(): array
    {
        $rawJson = $this->scopeConfig->getValue(self::XML_PATH_COLORS);
        $options = [];

        // Giải mã JSON
        $rawArray = json_decode($rawJson, true);

        // Đảm bảo là array sau khi decode
        if (is_array($rawArray)) {
            foreach ($rawArray as $row) {
                if (!empty($row['label']) && !empty($row['code'])) {
                    $options[] = [
                        'label' => $row['label'],
                        'value' => $row['code']
                    ];
                }
            }
        }

        return $options;
    }


    /** URL để lưu lựa chọn user (có thể không cần nếu dùng localStorage) */
    public function getSaveUrl(): string
    {
        return $this->getUrl('colorswitch/index/save');
    }
}
