<?php

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Escaper;

class OddEven extends Column
{
    protected $escaper;

    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        Escaper            $escaper,
        array              $components = [],
        array              $data = []
    )
    {
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $orderId = $item['entity_id'];
                $item['odd_even'] = $this->isOdd($orderId) ? 'Odd' : 'Even';
                $item['css_class'] = $this->isOdd($orderId) ? 'grid-severity-critical' : 'grid-severity-notice';
            }
        }
        return $dataSource;
    }

    private function isOdd($number)
    {
        return $number % 2 != 0;
    }
}