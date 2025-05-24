<?php

namespace Magenest\CustomAddress\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class VNRegion extends AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => 'Miền Bắc', 'value' => 1],
                ['label' => 'Miền Trung', 'value' => 2],
                ['label' => 'Miền Nam', 'value' => 3],
            ];
        }
        return $this->_options;
    }
}
