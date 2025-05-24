<?php

namespace Magenest\CustomAddress\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenest\CustomAddress\Model\Config\Source\VNRegion;

class VNRegionViewModel implements ArgumentInterface
{
    protected $vnRegionSource;

    public function __construct(VNRegion $vnRegionSource)
    {
        $this->vnRegionSource = $vnRegionSource;
    }

    public function getOptions()
    {
        return $this->vnRegionSource ? $this->vnRegionSource->getAllOptions() : [];
    }
}